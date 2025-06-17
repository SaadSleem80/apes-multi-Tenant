<?php

namespace Modules\Auth\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", maxLength=255),
 *     @OA\Property(property="email", type="string", maxLength=255, format="email"),
 *     @OA\Property(property="password", type="string", minLength=8),
 *     @OA\Property(property="password_confirmation", type="string", minLength=8),
 * )
 */

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
