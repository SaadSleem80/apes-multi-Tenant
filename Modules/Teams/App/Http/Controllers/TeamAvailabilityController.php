<?php

namespace Modules\Teams\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Modules\Teams\App\Http\Requests\TeamAvailabilityRequest;
use Illuminate\Http\JsonResponse;
use Modules\Teams\App\Http\Resources\TeamAvailabilityResource;
use Modules\Teams\App\Interfaces\TeamAvailabilityInterface;
use Modules\Teams\App\Services\GenerateTeamsAvailabilitySlots;
use Symfony\Component\HttpFoundation\Response;

class TeamAvailabilityController extends MainController
{
    private $repository;
    private $generateSlotsService;

    public function __construct(TeamAvailabilityInterface $repository, GenerateTeamsAvailabilitySlots $generateSlotsService)
    {
        $this->generateSlotsService = $generateSlotsService;
        $this->repository = $repository;
    }

    /**
     * Generate Team weekly availability
     * @param $team_id
     * @OA\Get(
     *  path="/api/teams/{id}/generate-slots",
     *  summary="Generate Team weekly availability",
     *  tags={"TeamsAvailability"},
     *  @OA\Parameter(name="id", in="path", required=true, description="ID of the team id", @OA\Schema(type="integer", example=1)),
     *  @OA\Parameter(name="from", in="query", description="Start Date", required=false, @OA\Schema(type="date")),
     *  @OA\Parameter(name="to", in="query", description="End Date", required=false, @OA\Schema(type="date")),
     *  @OA\Response(response="200", description="success"),
     * )
     * @return JsonResponse
     */
    public function generateSlots(Request $request, int $team_id): JsonResponse
    {
        $response = $this->generateSlotsService->handle($request, $team_id);
        return $this->response('success', $response, Response::HTTP_OK);
    }

    /**
     * Store Team weekly availability
     * @param $team_id
     * @param TeamAvailabilityRequest $request
     * @OA\Post(
     *  path="/api/teams/{id}/availability",
     *  summary="Store Team weekly availability",
     *  tags={"TeamsAvailability"},
     *  @OA\Parameter(name="id", in="path", required=true, description="ID of the team id", @OA\Schema(type="integer", example=1)),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/TeamAvailabilityRequest")
     *  ),
     *  @OA\Response(response="201", description="success"),
     * )
     * @return JsonResponse
     */
    public function store(TeamAvailabilityRequest $request, int $team_id): JsonResponse
    {
        $request = $request->validated();
        $response = $this->repository->createOrUpdateAvailability($request, $team_id);
        return $this->response('success' , TeamAvailabilityResource::collection($response), Response::HTTP_CREATED);
    }
}

