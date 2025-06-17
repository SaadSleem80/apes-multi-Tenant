<?php

namespace Modules\Bookings\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *  schema="BookingRequest",
 *  required={"team_id", "start_time", "end_time", "day"},
 *  @OA\Property(property="team_id", type="integer", example=1),
 *  @OA\Property(property="start_time", type="string", format="time", example="18:00"),
 *  @OA\Property(property="end_time", type="string", format="time", example="19:00"),
 *  @OA\Property(property="day", type="string", format="date", example="2025-06-17")
 * )
 */


 use Modules\Bookings\App\Services\ValidateBooking;

 class BookingRequest extends FormRequest
 {
     public function rules(): array
     {
         return [
             'team_id'       => ['required', 'integer', Rule::exists('teams', 'id')],
             'start_time'    => ['required', 'date_format:H:i'],
             'end_time'      => ['required', 'date_format:H:i', 'after:start_time'],
             'date'          => ['required', 'date_format:Y-m-d'],
         ];
     }
 
     public function authorize(): bool
     {
         return true;
     }
 
     public function passedValidation(): void
     {
         // ✅ Resolve the service from the container manually
         $validator = app(ValidateBooking::class);
 
         // ✅ Run custom validation logic
         $validator->handle($this->validated());
     }
 }
 
