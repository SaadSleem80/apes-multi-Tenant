<?php 

namespace Modules\Auth\App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\Tenants\App\Models\Tenant;
use Modules\Users\App\Http\Resources\UserResource;

class AuthServices { 
    private $user;
    private $tenant;

    public function __construct(User $user, Tenant $tenant) {
        $this->user = $user;
        $this->tenant = $tenant;
    }

    public function register($request) : User
    {
        // Create a new user
        $user = $this->user->create($request);

        // Create a new tenant for the user
        $this->tenant->create([
            'name'   => $request['name'],
            'domain' => $request['name'] . env('TENANT_DOMAIN_SUFFIX', '.apes.localhost'),
            'user_id' => $user->id,
        ]);

        return $user;
    }

    public function login ($request) : mixed
    {
        // Check the user
        if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) 
            throw new \Exception('Invalid credentials' , 401);

        /**
         * Define the user variable
         * @var User $user
         */
        $user = Auth::user();

        // Generate a new token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => new UserResource($user),
            'token' => $token
        ];
    }

}