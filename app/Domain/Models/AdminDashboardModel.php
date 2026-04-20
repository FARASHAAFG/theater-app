<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class AdminDashboardModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getTotalShows(): int
    {
        return $this->count("SELECT COUNT(*) from shows");
    }

    public function getTotalPosters(): int
    {
        return $this->count("SELECT COUNT(*) from posters");
    }
}
