<?php

namespace App\Http\Controllers;

use Socialite;

class KakaoController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('kakao')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('kakao')->user();

        dd($user);
    }
}
