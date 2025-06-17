<?php

namespace Modules\Teams\App\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Teams\App\Enums\WeekDays;

/**
 * @OA\Schema(
 *  schema="TeamAvailabilityRequest",
 *  required={"availability"},
 *  @OA\Property(
 *    property="availability",
 *    type="array",
 *    @OA\Items(
 *      type="object",
 *      required={"day", "start_time", "end_time"},
 *      @OA\Property(property="day", type="string", enum={"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"}),
 *      @OA\Property(property="start_time", type="string", format="time", example="09:00"),
 *      @OA\Property(property="end_time", type="string", format="time", example="17:00")
 *   )
 *  ),
 * )
 */

class TeamAvailabilityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'availability'                  => ['required', 'array', 'min:1'],
            'availability.*.day_of_week'    => ['required', 'string', new EnumValue(WeekDays::class, false)],
            'availability.*.start_time'     => ['required', 'date_format:H:i'],
            'availability.*.end_time'       => ['required', 'date_format:H:i', 'after:availability.*.start_time'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
