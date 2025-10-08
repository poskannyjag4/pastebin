<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
//use Laravel\Socialite\Contracts\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User;
use App\Models\User as Model;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{
    /**
     * @param AuthRepository $authRepository
     */
    public function __construct(
        private readonly AuthRepository $authRepository,
    )
    {
    }

    /**
     * Аутентификация пользователя по соцеильносй сети
     * @param string $provider
     * @param User $socialUser
     * @return void
     */
    public function loginBySocial(string $provider, \Laravel\Socialite\Contracts\User $socialUser): void
    {
        $user = $this->authRepository->getSocialUser($provider, $socialUser->getId());
        if (!is_null($user)) {
            Auth::login($user);
        }
        $newUser = \App\Models\User::create([
            'provider_name' => $provider,
            'provider_id' => $socialUser->getId(),
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail()
        ]);
        Auth::login($newUser);
    }

    /**
     * @param array{
     *     email: string,
     *     password: string
     * } $data
     * @return string
     */
    public function loginUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->authRepository->getOrCreate($data);

        return $user->createToken('auth_token')->plainTextToken;
    }

}
