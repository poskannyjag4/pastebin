<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return UserResource
     */
    public function index(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
