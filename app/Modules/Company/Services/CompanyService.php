<?php


namespace Modules\Company\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\Contracts\CompanyServiceInterface;
use Modules\Company\Repositories\CompanyRepository;

class CompanyService implements CompanyServiceInterface
{

    /**
     * @var CompanyRepository
     */
    private $companyRepo;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepo = $companyRepository;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data) : Model
    {
        return $this->companyRepo->create($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->companyRepo->all();
    }
}
