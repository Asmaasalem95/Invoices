<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Modules\Company\Models\Company;

class CreateInvoiceTest extends ApiAuthTestCase
{

    public function  test_un_authorized_user_cannot_add_invoice()
    {
        $token = $this->userLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $creditor = Company::factory()->create(['type' => 'creditor', 'debtor_total_limit' => 50000]);
        $debtor = Company::factory()->create(['type' => 'debtor', 'debtor_total_limit'=> null]);
        $params = [
            'creditor_id' => $creditor->id,
            'debtor_id' => $debtor->id,
            'due_date' => '12-10-2021',
            "total_amount" => 1000
        ];
        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }
    public function  test_authorized_user_can_add_invoice()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $creditor = Company::factory()->create(['type' => 'creditor', 'debtor_total_limit' => 50000]);
        $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit' => null]);
        $params = [
            'creditor_id' => $creditor->id,
            'debtor_id' => $debtor->id,
            'due_date' => '12-10-2021',
            "total_amount" => 10000000
        ];

        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_OK);
    }
    public function test_invalid_debtor_id()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
      $creditor = Company::factory()->create(['type' => 'creditor']);
      $params = [
          'creditor_id' => $creditor->id,
          'debtor_id' => $creditor->id,
          'due_date' => '12-10-2021',
          "total_amount" => 10000
      ];
        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    }
    public function test_invalid_creditor_id()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
      $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit'=> null]);
      $params = [
          'creditor_id' => $debtor->id,
          'debtor_id' => $debtor->id,
          'due_date' => '12-10-2021',
          "total_amount" => 10000
      ];
        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    }
    public function test_invalid_dueDate()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit'=> null]);
        $params = [
            'creditor_id' => $debtor->id,
            'debtor_id' => $debtor->id,
            'due_date' => '1-1-2021', // past date
            "total_amount" => 10000
        ];
        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    }
    public function test_invalid_total_amount()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $creditor = Company::factory()->create(['type' => 'creditor','debtor_total_limit'=> 500000]);
        $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit'=>null]);
        $params = [
            'creditor_id' => $creditor->id,
            'debtor_id' => $debtor->id,
            'due_date' => '12-10-2021',
            "total_amount" => 'text'
        ];
        $response = $this->createInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

    }
    protected function createInvoice($params,$headers)
    {
        return $this->withHeaders([
            $headers
        ])->json('POST', route('invoices.store'), $params);

    }
}
