<?php

namespace Modules\Auth\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", maxLength=255, format="email"),
 *     @OA\Property(property="password", type="string", minLength=8),
 * )
 */

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required' , 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
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
