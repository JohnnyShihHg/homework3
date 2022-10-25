<?php

namespace Tests\Feature\UserAuth;

use Tests\TestCase;
use App\Models\User;
use Tests\CreateUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResetPasswordTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    public function testResetPassword()
    {

        factory(User::class)->create();

        $user = User::first();

        $data = [
            'account' => $user->account,
            'oldPassword' => 'ps123',
            'newPassword' => 'newPassword123',
        ];

        $response = $this->asUser()->json('POST', '/api/user/resetPassword', $data);

        $response->assertStatus(200);
    }
}
