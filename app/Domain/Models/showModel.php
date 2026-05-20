<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class showModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Retrieve all cafes from the database.
     * @return array List of all cafes
     */
    public function getAllPosters(): array
    {
        return $this->selectAll(' SELECT * FROM posters JOIN shows ON posters.show_id = shows.show_id');
    }

    /**
     * Queries database to get all shows
     * @return array
     */
    public function getAllShows(): array
    {
        // Query to get ALL shows, even those without posters
        $sql = "SELECT s.*,
         p.poster_id
         FROM shows s
         LEFT JOIN posters p
         ON s.show_id = p.show_id";

        return $this->selectAll($sql);
    }

    /**
     * Queries DB to get shows that match the search and the filter
     * @param string $query
     * @param mixed $type
     * @return array
     */
    public function searchShows(string $query = '', ?string $type = ''): array
    {
        $sql = "SELECT s.*,
         p.*
         FROM shows s
         LEFT JOIN posters p
         ON s.show_id = p.show_id
         WHERE 1 = 1 ";

        $params = [];

        if ($query != '') {
            // Had to make a four the same param but with different names because otherwise it wasn't working D:
            $params['search1'] = $query;
            $params['search2'] = $query;
            $params['search3'] = $query;
            $params['search4'] = $query;
            $sql .= " AND (s.title LIKE CONCAT('%', :search1, '%')
            OR s.title_fr LIKE CONCAT('%', :search2, '%')
            OR s.description LIKE CONCAT('%', :search3, '%')
            OR s.description_fr LIKE CONCAT('%', :search4, '%'))";
        }

        if ($type != '') {
            $params['type'] = $type;
            $sql .= " AND s.show_type LIKE CONCAT('%', :type, '%') ";
        }

        $sql .= " GROUP BY s.show_id ORDER BY s.title ASC";

        return $this->selectAll($sql, $params);
    }

    /**
     * Queries DB to get a show by the poster id
     * @param int $id
     * @return array|bool
     */
    public function getById(int $id): array|false
    {
        $sql = "
        SELECT *, shows.title AS show_name
        FROM posters
        JOIN shows ON posters.show_id = shows.show_id
        WHERE posters.poster_id = :id
    ";

        return $this->selectOne($sql, ["id" => $id]);
    }

    /**
     * Gets posters given the show id
     * @param int $id
     * @return array|bool
     */
    public function getByShowId(int $id): array|false
    {
        $sql = "
        SELECT s.*, p.poster_id FROM shows s
        LEFT JOIN posters p ON s.show_id = p.show_id
        WHERE s.show_id = :id
    ";

        return $this->selectOne($sql, ["id" => $id]);
    }
    //! If $posterId is actually the inputted show_id maybe change the variable name
    /**
     * Gets schedules of a show given a poster id of an associated poster
     * @param int $posterId
     * @return array
     */
    public function getSchedulesByPosterId(int $posterId): array
    {
        $sql = "
        SELECT *
        FROM showings
        WHERE show_id = :posterId
        ORDER BY start_time ASC
    ";

        return $this->selectAll($sql, ['posterId' => $posterId]);
    }

    public function getBookingById(int $BookingId): array|false
    {
        $sql = "
        SELECT *
        FROM posters
        WHERE show_id = :showId";

        return $this->selectOne($sql, ['showId' => $BookingId]);
    }

    public function getPosterByShowId(int $showId): array|false
    {
        $sql = "
        SELECT *
        FROM posters
        WHERE show_id = :showId";

        return $this->selectOne($sql, ['showId' => $showId]);
    }
    public function getSeatsByRow($row_label)
    {
        $sql = ("SELECT * FROM seats WHERE row_label = :row_label
        ");


        return $this->selectAll($sql, ['row_label' => $row_label]);
    }
    public function getSeats(int $showId): array|false
    {
        $sql = "
        SELECT *
        FROM posters
        WHERE show_id = :showId";

        return $this->selectOne($sql, ['showId' => $showId]);
    }

    public function getSchedulesByShowId(int $showId): array
    {
        $sql = "
        SELECT *
        FROM showings
        WHERE show_id = :showId
        ORDER BY start_time ASC
    ";

        return $this->selectAll($sql, ['showId' => $showId]);
    }
    public function getSchedulesByShowingId(int $showingId): array
    {
        $sql = "
        SELECT *
        FROM showings
        WHERE showing_id = :showId
        ORDER BY start_time ASC
    ";

        return $this->selectAll($sql, ['showId' => $showingId]);
    }

    public function deletePosterById(int $id): bool
    {
        $sql = "DELETE FROM posters WHERE show_id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
    public function deleteShowById(int $id): bool
    {
        // 1. Delete from showings first (child table)
        // Disable foreign key checks temporarily
        $this->execute("SET FOREIGN_KEY_CHECKS = 0", []);

        // Delete all related records
        $sql = "DELETE FROM showings WHERE show_id = :id";
        $this->execute($sql, ['id' => $id]);

        $sql = "DELETE FROM posters WHERE show_id = :id";
        $this->execute($sql, ['id' => $id]);

        $sql = "DELETE FROM shows WHERE show_id = :id";
        $this->execute($sql, ['id' => $id]);

        // Re-enable foreign key checks
        $this->execute("SET FOREIGN_KEY_CHECKS = 1", []);

        return true;
    }

    public function createPoster(int $show_id, bool $is_used, $poster_image): bool
    {
        $sql = "INSERT INTO `posters` (`poster_id`, `show_id`, `poster_image`, `is_used`) VALUES (NULL, :show_id, :poster_image , :is_used);";
        return $this->execute($sql, ['show_id' => $show_id, 'poster_image' => $poster_image, 'is_used' => $is_used == "Yes" ? 1 : 0]); // ? 1 : 0 should transform the boolean into tinyint format
    }

    public function updateShow(String $title_fr, String $title, String $duration, String $genre, String $language, String $cast, String $show_type, String $is_active, String $description, String $description_fr, int $show_id): bool
    {
        $sql = "UPDATE `shows` SET `title_fr` = :title_fr, `title` = :title, `duration` = :duration, `genre` = :genre, `language` = :language, `cast` = :cast, `show_type` = :show_type, `is_active` = :is_active, `description` = :description, `description_fr` = :description_fr WHERE `show_id` = :show_id;";


        return $this->execute($sql, ['title_fr' => $title_fr, 'title' => $title, 'duration' => intval($duration), 'genre' => $genre, 'language' => $language, 'cast' => $cast, 'show_type' => $show_type, 'is_active' => $is_active === "Yes" ? 1 : 0, 'description' => $description, 'description_fr' => $description_fr, 'show_id' => $show_id]); // ? 1 : 0 should transform the boolean into tinyint format

    }

    public function addShow(String $title_fr, String $title, String $duration, String $genre, String $language, String $cast, String $show_type, String $is_active, String $description, String $description_fr): bool
    {
        $sql = "INSERT INTO `shows` (`title_fr`, `title`, `duration`, `genre`, `language`, `cast`, `show_type`, `is_active`, `description`, `description_fr`, `show_id`) VALUES (:title_fr, :title, :duration, :genre, :language, :cast, :show_type, :is_active, :description, :description_fr, NULL);";
        return $this->execute($sql, ['title_fr' => $title_fr, 'title' => $title, 'duration' => intval($duration), 'genre' => $genre, 'language' => $language, 'cast' => $cast, 'show_type' => $show_type, 'is_active' => $is_active === "Yes" ? 1 : 0, 'description' => $description, 'description_fr' => $description_fr]); // ? 1 : 0 should transform the boolean into tinyint format
    }
}
