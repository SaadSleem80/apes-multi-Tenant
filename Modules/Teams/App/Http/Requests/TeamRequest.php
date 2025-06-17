<?php

namespace Modules\Teams\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *  schema="TeamRequest",
 *  required={"name"},
 *  @OA\Property(property="name", type="string", maxLength=255, example="Development Team"),
 * )
 */

class TeamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
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
