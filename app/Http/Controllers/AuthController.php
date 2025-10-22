<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Socialite\Contracts\User as ContractsUser;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct(){}

    public function showLoginForm(){
        return view('auth.login');
    }

    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(RegisterDTO $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function login(LoginDTO $request){
        return redirect()->intended('/');
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('paste.home');
    }

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
            return redirect()->route('login')->with('email', 'Что-то пошло не так при входе через ' . $provider);
        }
    }
}
