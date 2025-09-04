<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //redirect
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    //callback
    public function callback($provider) {
        $socialLoginData = Socialite::driver($provider)->user();

        // dd($data);

    //     $user = User::updateOrCreate([
    //         'github_id' => $githubUser->id,
    //     ], [
    //         'name' => $githubUser->name,
    //         'email' => $githubUser->email,
    //         'github_token' => $githubUser->token,
    //         'github_refresh_token' => $githubUser->refreshToken,
    //     ]);


        // keep user data into database
        $user = User::updateOrCreate([
            // 'provider_id' => $socialLoginData->id,
            // 'provider' => $provider
            'email' => $socialLoginData->email,
        ], [
            'name' => $socialLoginData->name,
            'email' => $socialLoginData->email,
            'nickname' => $socialLoginData->nickname,
            // 'profile' => $socialLoginData->avatar,
            'provider' => $socialLoginData->$provider, // github || google
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'role' => 'user'
        ]);

        Auth::login($user);
        // auth()->login($user);

        // return to_route('admin#dashboard');
        return to_route('user#homePage');
    }
}
