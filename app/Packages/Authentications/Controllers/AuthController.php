<?php

namespace App\Packages\Authentications\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Packages\Users\Models\User;
use App\Packages\VirtualModels\Contracts\VirtualResourceContract;
use App\Packages\VirtualModels\Repositories\VirtualResourceRepository;
use App\Packages\VirtualModels\Resources\VirtualResourceResource;

class AuthController
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'repassword' => 'required|same:password'
        ]);

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken()->accessToken;
        return ('User has been registered');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $attempt = Auth::attempt(['email' => $username, 'password' => $password]);
        if ($attempt) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'login successfully'
            ]);
        } else {
            return $this->sendError('The provided credentials do not match our records.');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function getAuth(
        Request $request,
        VirtualResourceContract $resource
    )
    {
        $user = (env('APP_ENV') == 'local') ? User::first() : Auth::user();
        // $user = Auth::user();

        $user = $user->only(['name', 'email', 'id']);

        $resources = VirtualResourceResource::collection($resource->getMenu());
        return compact('user', 'resources');
    }
}
