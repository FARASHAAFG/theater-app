<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

/**
 * Model for admin dashboard
 */
class AdminDashboardModel extends BaseModel
{
    /**
     * Constructor for admin dashboard model
     * @param PDOService $db_service
     */
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Counts and returns the total amount of shows in the shows table of the DB
     * @return int
     */
    public function getTotalShows(): int
    {
        return $this->count("SELECT COUNT(*) from shows");
    }

    /**
     * Counts and returns the total amount of posters in the posters table of the DB
     * @return int
     */
    public function getTotalPosters(): int
    {
        return $this->count("SELECT COUNT(*) from posters");
    }

    public function getTotalShowings(): int
    {
        return $this->count("SELECT COUNT(*) FROM showings");
    }

    public function getShowsWithoutPoster(): int
    {
        return $this->count(
            "SELECT COUNT(*) FROM shows s
             WHERE s.is_active = 1
             AND NOT EXISTS (
                 SELECT 1 FROM posters p WHERE p.show_id = s.show_id AND p.is_primary = 1
             )"
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUpcomingShowings(int $limit = 6): array
    {
        $sql = "SELECT sh.showing_id, sh.room, sh.start_time, sh.base_price,
                       s.show_id, s.title, s.title_fr
                FROM showings sh
                INNER JOIN shows s ON s.show_id = sh.show_id
                WHERE sh.start_time >= NOW()
                ORDER BY sh.start_time ASC
                LIMIT " . (int) $limit;

        return $this->selectAll($sql);
    }
}
