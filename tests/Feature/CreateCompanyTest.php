<?php

namespace Tests\Feature;
use Illuminate\Http\JsonResponse;

class CreateCompanyTest extends ApiAuthTestCase
{

    public function test_un_authorized_user_cannot_create_company()
    {
        $token = $this->userLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $params =  [
            'name' => 'creditorCompany',
            'type' => 'creditor',
            'debtor_total_limit' => 100000
        ];
        $response = $this->createCompany($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }
    public function test_authorized_user_can_create_company()
    {
        $token = $this->adminLogin();
        $headers =  [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $params =  [
            'name' => 'creditorCompany',
            'type' => 'creditor',
            'debtor_total_limit' => 100000
        ];
        $response = $this->createCompany($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_OK);
    }
    public function test_cannot_create_company_without_name()
    {
        $token = $this->adminLogin();
        $headers =  [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $params = [
            "type" => 'debtor'
        ];
        $response = $this->createCompany($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_cannot_create_creditor_company_without_limit_debtor_value()
    {
        $token = $this->adminLogin();
        $headers =  [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $params = [
            'name'=>'creditorCompany',
            'type' => 'creditor',
        ];
        $response = $this->createCompany($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
    protected function createCompany($params,$headers)
    {
        return $this->withHeaders([
            $headers
        ])->json('POST', route('companies.store'), $params);
    }
}
