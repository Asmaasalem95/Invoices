<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\EloquentRepositoryInterface;

class BaseRepository implements EloquentRepositoryInterface
{

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        $model = $this->find($id);

        return $model->update($attributes);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return  $this->find($id)->delete();
    }

    /**
     * @param $key
     * @param $value
     * @return Model|null
     */
    public function where($key,$value) :?Model
    {
       return $this->model->where($key,$value)->first();
    }

}
