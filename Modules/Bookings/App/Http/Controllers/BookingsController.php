<?php

namespace Modules\Bookings\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Bookings\App\Http\Requests\BookingRequest;
use Modules\Bookings\App\Http\Resources\BookingResource;
use Modules\Bookings\App\Interfaces\BookingInterface;
use Symfony\Component\HttpFoundation\Response;

class BookingsController extends MainController
{
    private $repository;

    public function __construct(BookingInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get All Bookings
     * @param Request $request
     * @OA\Get(
     *  path="/api/v1/bookings",
     *  summary="Get All Bookings",
     *  tags={"Bookings"},
     *  @OA\Response(response="200", description="success")
     * )
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $response = $this->repository->fetchAll($request->toArray());
        if($response instanceof LengthAwarePaginator)
            return $this->paginatedResponse('success', BookingResource::collection($response), Response::HTTP_OK);
        return $this->response('success', BookingResource::collection($response), Response::HTTP_OK);
    }

    /**
     * Store a new Booking.
     * @param BookingRequest $request
     * @OA\Post(
     *  path="/api/v1/bookings",
     *  tags={"Bookings"},
     *  summary="Create a new Booking",
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/BookingRequest")
     *  ),
     *  @OA\Response(response="201", description="success"),
     * )
     * @return JsonResponse
     */
    public function store(BookingRequest $request): JsonResponse
    {
        $request = $request->validated();
        $team = $this->repository->create($request);
        return $this->response('success', new BookingResource($team), Response::HTTP_CREATED);
    }

    /**
     * Delete a Booking.
     * @param $id
     * @OA\Delete(
     *  path="/api/v1/bookings",
     *  tags={"Bookings"},
     *  summary="Delete a Booking",
     *     @OA\Parameter(name="id", in="path", required=true, description="ID of the booking to delete",
     *     @OA\Schema(type="integer", example=1)),
     *  @OA\Response(response="200", description="success"),
     * )
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return $this->response('success', null, Response::HTTP_OK);
    }
}
