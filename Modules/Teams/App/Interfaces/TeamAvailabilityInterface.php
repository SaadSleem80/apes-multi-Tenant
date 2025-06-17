<?php

namespace Modules\Teams\App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TeamAvailabilityInterface { 
    /**
     * Create or update the weekly availability of a team.
     *
     * @param array $request
     * @param int $team_id
     * @return Collection
     */
    public function createOrUpdateAvailability(array $data, int $team_id): Collection;
}