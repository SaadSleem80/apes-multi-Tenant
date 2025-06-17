<?php

namespace Modules\Bookings\App\Services;

use Carbon\Carbon;
use Modules\Bookings\App\Models\Booking;
use Modules\Teams\App\Models\Team;

class ValidateBooking
{
    private $booking;
    private $team;

    public function __construct(Booking $booking, Team $team)
    {
        $this->booking = $booking;
        $this->team = $team;
    }

    public function handle($request)
    {
        $this->checkTeamAvailabiliy($request);
        $this->checkBookingAvailabiliy($request);
    }

    private function checkTeamAvailabiliy($data): void
    {
        $day = Carbon::parse($data['date'])->dayOfWeek;
        $checkAvailabiliy = $this->team
                            ->find($data['team_id'])
                            ->teamAvailability()
                            ->where('day_of_week', $day)
                            ->where(function ($query) use ($data) {
                                $query->where('start_time', '<', $data['end_time'])
                                      ->where('end_time', '>', $data['start_time']);
                            })
                            ->count();

        if($checkAvailabiliy == 0)
            throw new \Exception('The team is not available at the selected time.');   
    }
    
    private function checkBookingAvailabiliy($data): void
    {
        // Check if the time is already taken
        $checkIfExist = $this->booking
                            ->where('team_id', $data['team_id'])
                            ->where('date', $data['date'])
                            ->where(function ($query) use ($data) {
                                $query->where('start_time', '<', $data['end_time'])
                                      ->where('end_time', '>', $data['start_time']);
                            })
                            ->first();
        if($checkIfExist)
            throw new \Exception('There is a Booking already exists for the selected time.');
    }
}
