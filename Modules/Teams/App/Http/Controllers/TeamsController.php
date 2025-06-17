<?php

namespace Modules\Teams\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Teams\App\Http\Requests\TeamRequest;
use Modules\Teams\App\Http\Resources\TeamResource;
use Modules\Teams\App\Interfaces\TeamInterface;
use Symfony\Component\HttpFoundation\Response;

class TeamsController extends MainController
{
    private $repository;

    public function __construct(TeamInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the Teams.
     * @param Request $request
     * @OA\Get(
     *  path="/api/v1/teams",
     *  tags={"Teams"},
     *  summary="Get all Teams",
     *  @OA\Response(response="200", description="success"),
     * )
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $response = $this->repository->fetchAll($request->all());
        if($response instanceof LengthAwarePaginator)
            return $this->paginatedResponse('success' , TeamResource::collection($response), Response::HTTP_OK);
        return $this->response('success', TeamResource::collection($response), Response::HTTP_OK);
    }

    /**
     * Store a new Team.
     * @param TeamRequest $request
     * @OA\Post(
     *  path="/api/v1/teams",
     *  tags={"Teams"},
     *  summary="Create a new Team",
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/TeamRequest")
     *  ),
     *  @OA\Response(response="201", description="success"),
     * )
     * @return JsonResponse
     */
    public function store(TeamRequest $request): JsonResponse
    {
        $request = $request->validated();
        $team = $this->repository->create($request);
        return $this->response('success', new TeamResource($team), Response::HTTP_CREATED);
    }
}
