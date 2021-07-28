<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

class LoginUserTest extends ApiAuthTestCase
{


    protected $invalidEmail = 'invalid@example.com';

    protected $invalidPassword = 'invalid';

    protected $resendVerificationEmailRoute;

    protected $validEmail = 'mail@example.com';

    protected $validPassword = 'password123456';


    function test_user_can_not_login_without_email()
    {
        $response = $this->attemptLogin([
            'password' => $this->validPassword
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertGuest();
    }


    function test_user_can_not_login_without_password()
    {
        $response = $this->attemptLogin([
            'email' => $this->validEmail,
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertGuest();
    }

   function test_user_can_not_login_with_invalid_email()
    {
        $response = $this->attemptLogin([
            'email' => $this->invalidEmail,
            'password' => $this->validPassword,
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => "Failed! email not found."]);
        $this->assertGuest();
    }


    function test_can_not_login_with_invalid_password()
    {
        $user = $this->createUser();
        $response = $this->attemptLogin([
            'email' => $this->validEmail,
            'password' => $this->invalidPassword,
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => "Whoops! invalid password."]);
        $this->assertGuest();
    }

   function test_response_contain_token_when_user_login_successfully()
    {
        $this->enableCsrfProtection();
        $user = $this->createUser();
        $response = $this->attemptLogin([
            'email' => $this->validEmail,
            'password' => $this->validPassword
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertAuthenticatedAs($user);

    }


    protected function createUser()
    {
        return User::factory()->create([
            'email' => $this->validEmail,
            'password' => Hash::make($this->validPassword),
        ]);
    }

}
