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
}
