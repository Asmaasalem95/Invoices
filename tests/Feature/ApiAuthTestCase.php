<?php


namespace Tests\Feature;


use Modules\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiAuthTestCase extends TestCase
{

    use DatabaseTransactions;


    protected function userLogin()
    {
        $user = User::factory()->create(['role' => 'user']);
        $params = [
            'email' => $user->email,
            'password'=> 'password'
        ];
        $token = $this->attemptLogin($params)->decodeResponseJson()['data']['token'];
        return $token;
    }
    protected function adminLogin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $params = [
            'email' => $user->email,
            'password'=> 'password'
        ];
        $token = $this->attemptLogin($params)->decodeResponseJson()['data']['token'];
        return $token;
    }
    protected function enableCsrfProtection()
    {
        // csrf is disabled when running tests, but we want to turn it on
        // so our token actually gets verified
        // just needs to be something other than 'testing'
        $this->app['env'] = 'development';
    }

    public function attemptLogin($params)
    {
        return $this->json('POST', route('login'), $params);
    }
}
