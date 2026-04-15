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

    public function getAllShows(): array
    {
        // Query to get ALL shows, even those without posters
        $sql = "SELECT
         s.show_id, s.title, s.title_fr, s.duration, s.genre, s.language, s.show_type, s.is_active, p.poster_id
         FROM shows s
         LEFT JOIN posters p
         ON s.show_id = p.show_id";

        return $this->selectAll($sql);
    }

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
    //! If $posterId is actually the inputted show_id maybe change the variable name
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


    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM posters WHERE poster_id = :id";
        return $this->execute($sql, ['id' => $id]);
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
