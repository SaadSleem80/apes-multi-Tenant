<?php

namespace Modules\Teams\App\Services;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Modules\Teams\App\Models\Team;

class GenerateTeamsAvailabilitySlots
{
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function handle($request, $team_id): array 
    {
        $startDay = Carbon::parse($request['from']);
        $endDay = Carbon::parse($request['to']);

        // Create the period Between Two Dates
        $days = CarbonPeriod::create($startDay, $endDay);

        $slots = [];

        foreach($days as $day) { 
            // Get the Day From Team Availability
            $teamAvailability = $this->team?->find($team_id)
            ?->teamAvailability()
            ->where('day_of_week', $day->dayOfWeek)
            ->first();

            if(!isset($teamAvailability)) 
                continue;

            // return the day date as key and the available slots
            $getTimesSlotes = $this->getSlotsBetweenTimes($teamAvailability->start_time, $teamAvailability->end_time);
            $slots[$day->toDateString()] = $this->excludedBookingTimes($day->toDateString(), $team_id, $getTimesSlotes);
        }

        return $slots;
    }

    private function getSlotsBetweenTimes($startTime, $endTime): array
    { 
        $slots = [];

        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->copy();
            $slotEnd = $startTime->copy()->addHour();

            // Only include if within the original range
            if ($slotEnd->lte($endTime)) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ];
            }

            $startTime->addHour();
        }

        return $slots;
    }

    private function excludedBookingTimes($date, $team_id, $slots)
    {
        $excludedTimes = $this->team
                            ->find($team_id)
                            ?->teamBookings()
                            ->where('date', $date)
                            ->get();
                            
        // overlap the excluded times
        $availableSlots = array_filter($slots, function ($slot) use ($excludedTimes) {
            $slotStart = Carbon::createFromFormat('H:i', $slot['start']);
            $slotEnd = Carbon::createFromFormat('H:i', $slot['end']);
        
            foreach ($excludedTimes as $booking) {
                $bookingStart = Carbon::createFromFormat('H:i:s', $booking->start_time);
                $bookingEnd = Carbon::createFromFormat('H:i:s', $booking->end_time);
        
                if (
                    $slotStart->lt($bookingEnd) &&
                    $slotEnd->gt($bookingStart)
                ) {
                    return false;
                }
            }
            return true;
        });
                            
        return array_values($availableSlots);
    }
}
