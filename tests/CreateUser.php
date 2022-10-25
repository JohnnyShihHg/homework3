<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait CreateUser
{
    public function createUser()
    {
        factory(User::class)->create();

        $user = User::first();

        $data = [
            'account' => $user->account,
            'password' => 'ps123'
        ];

        $response = $this->json('POST', '/api/user/login', $data);

        return $response;
    }

    protected function asUser()
    {
        $user = User::first();

        $data = [
            'account' => $user->account,
            'password' => 'ps123'
        ];

        $response = $this->json('POST', '/api/user/login', $data);

        Auth::unsetToken();
        return $this->withHeader('Authorization', 'Bearer ' . $response['access_token']);
    }
}
