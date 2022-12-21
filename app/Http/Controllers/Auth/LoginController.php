<?php

namespace App\Http\Controllers\Auth;

use App\Maintainer;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LoginController
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->scopes(['read:org'])->redirect();
    }

    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $orgs = Http::withToken($githubUser->token)->get('https://api.github.com/user/orgs');

        abort_unless(collect($orgs->json())->contains(function ($org) {
            return $org['login'] === config('app.organization');
        }), 403);

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_username' => $githubUser->nickname,
            'github_id' => $githubUser->id,
            'avatar_url' => $githubUser->avatar,
        ]);

        // If the username is also in the maintainers table, associate the user with the maintainer,
        // or create a new maintainer record for this user
        Maintainer::updateOrCreate([
            'github_username' => $githubUser->nickname,
        ], [
            'user_id' => $user->id,
        ]);

        Auth::login($user, remember: true);

        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->intended('/');
    }
}
