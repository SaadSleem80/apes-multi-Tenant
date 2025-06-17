<?php

namespace Modules\Teams\App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Teams\App\Interfaces\TeamAvailabilityInterface;
use Modules\Teams\App\Models\Team;

class TeamAvailabilityRepository implements TeamAvailabilityInterface{
    private $teamModel;

    public function __construct(Team $teamModel)
    {
        $this->teamModel = $teamModel;
    }

    public function createOrUpdateAvailability($request, $team_id): Collection
    {
        $team = $this->teamModel->find($team_id);
        
        if (!$team) 
            throw new \Exception("Team not found");

        $processedIds = [];

        foreach ($request['availability'] as $data) {
            // Create or update based on unique constraint
            $availability = $team->teamAvailability()->updateOrCreate(
                [
                    'day_of_week' => $data['day_of_week'],
                    'start_time'  => $data['start_time'],
                    'end_time'    => $data['end_time'],
                ],
                [
                    'team_id'     => $team_id,
                ]
            );
    
            $processedIds[] = $availability->id;
        }
        
        // Delete all records not present in this request (i.e. synced out)
        $team->teamAvailability()
                ->whereNotIn('id', $processedIds)
                ->delete();

        return $team->teamAvailability;
    }
}