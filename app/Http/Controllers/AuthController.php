<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Models\User;
use App\Models\UserSocial;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Socialite\Contracts\User as ContractsUser;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SocialiteRedirectResponse;

class AuthController extends Controller
{

    function __construct(
        private UserService $userService,
    )
    {

    }
    /**
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * @return View
     */
    public function showRegisterForm(): View
    {

        return view('auth.register');
    }

    /**
     * @param RegisterDTO $request
     * @return RedirectResponse
     */
    public function register(RegisterDTO $request): RedirectResponse
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    /**
     * @param LoginDTO $request
     * @return RedirectResponse
     */
    public function login(LoginDTO $request): RedirectResponse
    {
        return redirect()->intended('/');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('paste.home');
    }

    /**
     * @param string $provider
     * @return SocialiteRedirectResponse
     */
    public function redirect(string $provider): SocialiteRedirectResponse
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

            $newUserSocial = new UserSocial();
            $newUserSocial->provider_id = $socialUser->getId();
            $newUserSocial->provider_name = $provider;

            $user = User::whereEmail($socialUser->getEmail())->first();

            $userSocial = [
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId()
            ];
            if(!is_null($user)){
                if(UserSocial::whereProviderId($newUserSocial->provider_id)->count() != 0){
                    Auth::login($user);
                    return redirect()->route('paste.home');
                }

                $newUserSocial->user()->associate($user);
                 $newUserSocial->save();

                Auth::login($user);
                return redirect('/');
            }

            $user = User::create([
                'name' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail()
            ]);

            $newUserSocial->user()->associate($user);
            $newUserSocial->save();

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->route('login.show')->with('email', 'Что-то пошло не так при входе через ' . $provider);
        }
    }

    public function getToken(){

        $token =$this->userService->generateToken(Auth::user());
        return \view('auth.api-token', ['token' => $token]);
    }
}
