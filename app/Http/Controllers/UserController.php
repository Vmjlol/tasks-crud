<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{

    public function __construct(
        private $user = new User()
    )
    {}

    /**
     * Delete logged user
     * @param void
     */
    public function delete(){
        User::findOrfail(auth()->id())->delete();
        return response()->json(['message' => 'User deleted']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
