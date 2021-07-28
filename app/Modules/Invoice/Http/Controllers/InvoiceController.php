<?php

namespace Modules\Invoice\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\CommonMethods;
use Illuminate\Http\Response;
use Modules\Invoice\Contracts\InvoiceServiceInterface;
use Modules\Invoice\Http\Requests\CreateInvoiceRequest;
use Modules\Invoice\Http\Requests\PayInvoiceRequest;
use Modules\Invoice\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{

    use CommonMethods;
    /**
     * @var InvoiceServiceInterface
     */
    private $service;

    /**
     * InvoiceController constructor.
     * @param InvoiceServiceInterface $invoiceService
     */
    public function __construct(InvoiceServiceInterface $invoiceService)
    {
        $this->service = $invoiceService;
    }

    /**
     * @param CreateInvoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateInvoiceRequest $request)
    {

        $invoiceCreated = $this->service->store($request->except('token'));
        if (!$invoiceCreated) {
            return $this->apiResponse(__('messages.debtor_reach_limit'), Response::HTTP_OK, []);
        } else {
            return $this->apiResponse(__('messages.data_created'), Response::HTTP_OK, InvoiceResource::make($invoiceCreated));
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {    $invoices = $this->service->all();
        return $this->apiResponse(__('messages.data_retrieved'), Response::HTTP_OK, InvoiceResource::collection($invoices));
    }

    /**
     * @param PayInvoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payInvoice(PayInvoiceRequest $request)
    {
        $invoiceId = $request->invoice_id;
        $paidChecker = $this->service->checkIfTheInvoicePaid($invoiceId);
        if ($paidChecker)
        {
            return $this->apiResponse(__('messages.invoice_already_paid'), Response::HTTP_OK, []);

        }
        $updated = $this->service->makeInvoicePaid($invoiceId);
        return $this->apiResponse(__('messages.invoice_paid'), Response::HTTP_OK, []);

    }



}
