<?php

namespace App\Repositories;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class BaseRepository
{
    /**
     * @var class-string<TModel>
     */
    protected string $modelClass;

    /**
     * @return TModel
     */
    public function find(int $id)
    {
        return ($this->modelClass)::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function all()
    {
        return ($this->modelClass)::all();
    }

    /**
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<TModel>
     */
    public function getAllPaginated(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ($this->modelClass)::paginate($perPage);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $model = $this->find($id);
        $model->delete();
    }
}
