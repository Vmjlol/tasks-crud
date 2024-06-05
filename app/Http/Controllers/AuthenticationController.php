<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

    public function __construct(
        private $user = new User()
    )
    {}

    /**
     * Register a new user
     *
     * @param  Request  $request
     * @return  \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|email|string|unique:users,email',
                'password' => 'required|string|min:8',
            ],
            [
                'name.required' => 'Insira um nome',
                'email.required' => 'Insira um email',
                'password.required' => 'Insira uma senha',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
        $user->save();

        $token = auth()->login($user);

        return response()->json([
            'message' => 'User created',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    /**
     * Authenticate login
     * 
     * @param Request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|string',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required' => 'Insira um email',
                'password.required' => 'Insira uma senha',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $this->jsonResponse($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'user' => auth()->user(),
            'expires_in'   => env('JWT_TTL', 60) * 60 * 24
        ]);
    }
}
