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
}
