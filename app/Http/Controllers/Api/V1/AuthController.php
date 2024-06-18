<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $credentials = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        // Check if the user already exists
        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {

            // Create the user
            $user = User::create($credentials);

            // Directly log in the user
            Auth::login($user);

            // Create tokens with different scopes
            $token = $user->createToken('admin-token', ['create', 'update', 'delete']);
            // $updateToken = $user->createToken('update-token', ['create', 'update']);
            // $basicToken = $user->createToken('basic-token',);

            // Prepare response data
            $res = [
                'user' => $user,
                'admin' => $token->plainTextToken,
                // 'update' => $updateToken->plainTextToken,
                // 'basic' => $basicToken->plainTextToken
            ];

            return $this->success($res, "User Created", 200);
        } else {
            return $this->success([], "User already exists", 200);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // Check if the user already exists
        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return $this->error("", "Credentials doesn't exist", 401);
        }
        $user = User::where('email', $request->email)->first();
        Auth::login($user);

        $token = $user->createToken('admin-token', ['create', 'update', 'delete']);

        // Prepare response data
        $res = [
            'user' => $user,
            'admin' => $token->plainTextToken,
            // 'update' => $updateToken->plainTextToken,
            // 'basic' => $basicToken->plainTextToken
        ];

        return $this->success($res, "User Logged-in", 200);

    }
}
