<?php 

namespace Modules\Teams\App\Interfaces;
use Illuminate\Database\Eloquent\Collection;
use Modules\Teams\App\Models\Team;

interface TeamInterface {
    /**
     * Fetch all teams with optional filters.
     *
     * @param array $filters
     * @return mixed
     */
    public function fetchAll(array $filters): mixed;

    /**
     * Create a new team.
     *
     * @param array $data
     * @return Team
     */
    public function create(array $data): Team;

    /**
     * Create Or Update Availability.
     *
     * @param array $data
     * @param int $id
     * @return Collection
     */
}