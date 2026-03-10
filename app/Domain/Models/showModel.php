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
        return $this->selectAll('SELECT * FROM posters');
    }
}
