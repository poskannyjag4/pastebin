<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Str;

class SocialiteController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    /**
     * @param string $provider
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param string $provider
     * @return RedirectResponse
     */
    public function callback(string $provider): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $this->authService->loginBySocial($provider, $socialUser);
            return redirect()->route('paste.home');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Что-то пошло не так при входе через ' . $provider);
        }
    }
}
