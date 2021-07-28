<?php


namespace  Modules\Company\Repositories;

use App\Repositories\BaseRepository;
use Modules\Company\Models\Company;

class CompanyRepository extends BaseRepository
{

    /**
     * @var Company
     */
    protected $model;

    /**
     * CompanyRepository constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->model = $company;
    }



}
