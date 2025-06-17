<?php

namespace Modules\Bookings\App\Repositories;

use Exception;
use Modules\Bookings\App\Models\Booking;
use Modules\Bookings\App\Interfaces\BookingInterface;

class BookingRepository implements BookingInterface
{
    private $model;

    public function __construct(Booking $model)
    {
        $this->model = $model;
    }

    public function fetchAll(array $filters): mixed
    {
        $query = $this->model
                    ->with(['team']);

        if(isset($filters['paginate']))
            return $query->paginate($filters['perPage']);

        return $query->get();
    }

    public function create(array $request): Booking
    {
        $booking = $this->model->create($request);

        return $booking;
    }

    public function delete(int $id): void
    {
        $booking = $this->model->find($id);

        if(!$booking)
            throw new Exception('Booking not found');

        $booking->delete();
    }
}
