<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ApiLoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
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
           
            $user = $this->userService->getUserByLogin($request);
            $token = $user->createToken('api')->plainTextToken;
            info($token);
            return $token;
        }
        catch (\Exception $exception){
            return response()->json(['error' => 'Произошла ошибка!'], 500);
        }

    }
}
