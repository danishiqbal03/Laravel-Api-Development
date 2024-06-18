<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreUserRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'password' => $request->password,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
