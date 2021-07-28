<?php


namespace Modules\User\Services;

use Modules\User\Contracts\UserServiceInterface;
use Modules\User\Repositories\UserRepository;

class UserService implements UserServiceInterface
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }
    /**
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function findByEmail($email,$value)
    {
        return $this->repository->where($email,$value);
    }


}
