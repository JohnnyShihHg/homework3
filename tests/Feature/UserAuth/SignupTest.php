<?php

namespace Tests\Feature\UserAuth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignupTest extends TestCase
{
    use DatabaseTransactions;

    public function testSignup()
    {
        $data = [
            'account' => 'johnny',
            'password' => 'ps123',
            'phone_no' => '0800092000'
        ];

        $response = $this->json('POST', '/api/user/signup', $data);

        $response->assertStatus(200);
    }
}
