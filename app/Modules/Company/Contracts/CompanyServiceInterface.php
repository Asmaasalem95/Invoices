<?php


namespace Modules\Company\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CompanyServiceInterface
{

    /**
     * @param $data
     * @return Model
     */
    public function store($data) : Model;

    /**
     * @return Collection
     */
    public function all() : Collection ;

}
