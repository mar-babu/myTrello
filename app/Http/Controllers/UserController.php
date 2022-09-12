<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        return Cache::remember('users', 60 * 5, function () {
//            $response = Http::dd()->get('http://127.0.0.1:8000/api/users');
            $response = Http::retry(3, 100)->timeout(3)->get('http://localhost:8000/api/users');
            if ($response->successfull()) {
                return $response->json('abdur');
            }

            return response()->json([]);
        });
    }
}
