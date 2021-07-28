<?php


namespace Modules\User\Contracts;


interface UserServiceInterface
{

    /**
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function findByEmail($email, $value);


}
