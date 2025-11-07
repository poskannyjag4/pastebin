<?php

namespace App\Http\Controllers;

use App\DTOs\RegisterDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UserSocial;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SocialiteRedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $registerDto = RegisterDTO::from($request->validated());
        $user = User::create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => Hash::make($registerDto->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        return redirect()->intended('/');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('paste.home');
    }

    public function redirect(string $provider): SocialiteRedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $newUserSocial = new UserSocial;
            $newUserSocial->provider_id = $socialUser->getId();
            $newUserSocial->provider_name = $provider;

            $user = User::whereEmail($socialUser->getEmail())->first();

            if (! is_null($user)) {
                if (UserSocial::whereProviderId($newUserSocial->provider_id)->count() != 0) {
                    Auth::login($user);

                    return redirect()->route('paste.home');
                }

                $newUserSocial->user()->associate($user);
                $newUserSocial->save();

                Auth::login($user);

                return redirect()->route('paste.home');
            }

            $user = User::create([
                'name' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
            ]);

            $newUserSocial->user()->associate($user);
            $newUserSocial->save();

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->route('login.show')->with('email', 'Что-то пошло не так при входе через '.$provider);
        }
    }

    public function getToken(): View
    {
        $token = $this->userService->generateToken(Auth::user());

        return view('auth.api-token', ['token' => $token]);
    }
}
