<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function getUsers()
    {
        return UserResource::collection(Cache::remember('getUsers', 60 * 5, function () {
            return User::all();
        }));

    }

}
