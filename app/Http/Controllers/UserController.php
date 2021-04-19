<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRessource;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Retrieve all user
     */
    public function index()
    {
        $users = User::all()->load('topics');
        return response(['users' => UserRessource::collection($users), 'message' => 'Retrieved all users'], 200);
    }

}
