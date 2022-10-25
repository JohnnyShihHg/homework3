<?php

namespace Tests\Feature\UserAuth;

use Tests\TestCase;
use Tests\CreateUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    public function testLogout()
    {
        $this->createUser();

        $response = $this->asUser()->json('POST', '/api/user/logout', []);

        $response->assertStatus(200);
    }
}
