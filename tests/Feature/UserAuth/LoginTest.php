<?php

namespace Tests\Feature\UserAuth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogin()
    {
        factory(User::class)->create();

        $user = User::first();

        $data = [
            'account' => $user->account,
            'password' => 'ps123'
        ];

        $response = $this->json('POST', '/api/user/login', $data);
        $response->assertStatus(200);
    }
}
