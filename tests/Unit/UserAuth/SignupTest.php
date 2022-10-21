<?php

namespace Tests\Unit\UserAuth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SignupTest extends TestCase
{
    use DatabaseTransactions;

    public function testSignup()
    {
        $user = factory(User::class)->create();

        $response = User::where('id', $user->id)
            ->get()->toArray();

        $this->assertTrue($response[0]['phone_no'] == '0800092000');
    }
}
