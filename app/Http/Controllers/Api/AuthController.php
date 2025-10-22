<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ApiLoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(
        private UserService $userService
    )
    {
    }

    /**
     * @param ApiLoginDTO $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(ApiLoginDTO $request){
        try{
            
            $token = $this->userService->getToken($request);
            return response()->json(['token' => $token], 201);
        }
        catch (\Exception $exception){
            return response()->json(['error' => 'Произошла ошибка!'], 500);
        }

    }
}
