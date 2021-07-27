<?php


namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface EloquentRepositoryInterface
{
    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'],array $relations = []) : Collection;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id , array $attributes) : bool;


    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

}
