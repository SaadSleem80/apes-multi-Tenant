<?php

namespace Modules\Teams\App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Teams\App\Interfaces\TeamInterface;
use Modules\Teams\App\Models\Team;

class TeamRepository implements TeamInterface{ 
    
    private $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function fetchAll($filters): mixed
    {
        $query = $this->model
            ->search($filters['search'] ?? null);

        if (isset($filters['paginate']))
            return $query->paginate($filters['perPage'] ?? 10);

        return $query->get();
    }

    public function create(array $request): Team
    {
        $team = $this->model->create($request);

        return $team;
    }
}