<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function getUsers()
    {
        return Cache::remember('users', 60 * 5, function () {
            return Http::retry(3, 100)->timeout(3)->get('https://jsonplaceholder.typicode.com/users')->json();
        });

    }

}
