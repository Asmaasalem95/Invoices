<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Modules\Company\Models\Company;
use Modules\Invoice\Models\Invoice;

class MakeInvoicePaidTest extends ApiAuthTestCase
{

    public function test_un_authorized_user_cannot_make_invoice_paid()
    {
        $token = $this->userLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $creditor = Company::factory()->create(['type' => 'creditor', 'debtor_total_limit' => 50000]);
        $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit'=> null]);
        //create invoice for debtor
        $invoice = Invoice::factory()->create(['creditor_id' => $creditor->id, 'debtor_id' => $debtor->id, 'total_amount' => 10000, 'status' => 0]);
        $params = [
            'invoice_id'=> $invoice->id
        ];
        $response = $this->payInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);
    }
    public function test_authorized_user_can_make_invoice_paid()
    {
        $token = $this->adminLogin();
        $headers =  $headers = [
            'Accept'        => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token
        ];
        $creditor = Company::factory()->create(['type' => 'creditor', 'debtor_total_limit' => 50000]);
        $debtor = Company::factory()->create(['type' => 'debtor','debtor_total_limit'=> null]);
        //create invoice for debtor
        $invoice = Invoice::factory()->create(['creditor_id' => $creditor->id, 'debtor_id' => $debtor->id, 'total_amount' => 10000, 'status' => 0]);
        $params = [
            'invoice_id'=> $invoice->id
        ];
        $response = $this->payInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_OK);
    }
    public function test_pay_invoice_required_valid_invoice_id()
    {
              $token = $this->adminLogin();
              $headers =  $headers = [
                  'Accept'        => 'application/json',
                  'AUTHORIZATION' => 'Bearer ' . $token
              ];
        $params = [
            'invoice_id'=> 'text'
        ];
        $response = $this->payInvoice($params,$headers);
        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(['status' => false]);
    }

    protected function payInvoice($params,$headers)
    {
        return $this->withHeaders([
            $headers
        ])->json('POST', route('pay-invoice'), $params);
    }

}
