<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(
        private AuthService $authService
    )
    {
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){
        try{
            $token = $this->authService->loginUser($request->validated());
            return response()->json(['token' => $token], 201);
        }
        catch (\Exception $exception){
            return response()->json(['error' => 'Произошла ошибка!'], 500);
        }

    }
}
