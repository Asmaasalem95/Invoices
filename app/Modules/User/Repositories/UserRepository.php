<?php


namespace Modules\User\Repositories;


use App\Repositories\BaseRepository;
use Modules\User\Models\User;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

}
