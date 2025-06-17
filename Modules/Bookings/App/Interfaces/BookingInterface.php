<?php

namespace Modules\Bookings\App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\Bookings\App\Models\Booking;

interface BookingInterface {    
    /**
    * Get All Bookings.
    *
    * @param array $filters
    * @return mixed
    */
    public function fetchAll(array $filters) : mixed;

    /**
     * Create a new Booking.
     *
     * @param array $request
     * @return Collection
     */
    public function create(array $request): Booking;

    /**
     * Delete a Booking.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void;
}
