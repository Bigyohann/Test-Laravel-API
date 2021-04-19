<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRessource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     */
    public function index()
    {
        $users = User::all();
        return response(['users' => UserRessource::collection($users), 'message' => 'Retrieved all users'], 200);
    }



}