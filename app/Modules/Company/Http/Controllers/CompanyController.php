<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\CommonMethods;
use Illuminate\Http\Response;
use Modules\Company\Contracts\CompanyServiceInterface;
use Modules\Company\Http\Requests\CreateCompanyRequest;
use Modules\Company\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    use CommonMethods;

    /**
     * @var CompanyServiceInterface
     */
    private $service;

    /**
     * CompanyController constructor.
     * @param CompanyServiceInterface $companyService
     */
    public function __construct(CompanyServiceInterface $companyService)
    {
        $this->service = $companyService;
    }

    /**
     * @param CreateCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCompanyRequest $request)
    {
        $data = $request->all();
        $createdCompany = $this->service->store($data);
        return $this->apiResponse(__('messages.data_created'), Response::HTTP_OK, CompanyResource::make($createdCompany));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = $this->service->all();
        return $this->apiResponse(__('messages.data_retrieved'), Response::HTTP_OK, CompanyResource::collection($companies));
    }
}
