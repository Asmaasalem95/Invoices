<?php


namespace Tests\Feature;


use Modules\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiAuthTestCase extends TestCase
{

    use DatabaseTransactions;

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
