<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository
 *
 * @package App\Repositories
 */
abstract class Repository
{
    /**
     * @var Model|string
     */
    protected $modelClass;
    /**
     * @var bool
     */
    protected $throwableWhenNotSaved = false;
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new $this->modelClass();
    }

    /**
     * @param array $data
     * @return Model
     * @throws \Exception
     */
    public function create(array $data): Model
    {
        $newInstance = $this->model->newInstance($data);
        if (! $newInstance->save() && $this->throwableWhenNotSaved) {
            throw new \Exception('Model not saved');
        }

        return $newInstance;
    }

    /**
     * @param int $id
     * @param array|string[] $columns
     * @return mixed
     */
    public function read(int $id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     * @throws \Exception
     */
    public function update(Model $model, array $data): Model
    {
        $model->fill($data);
        if (! $model->save() && $this->throwableWhenNotSaved) {
            throw new \Exception('Model not saved');
        }

        return $model;
    }

    /**
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Model $model): bool
    {
        if (! $model->delete() && $this->throwableWhenNotSaved) {
            throw new \Exception('Model not saved');
        }

        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return Builder
     */
    public function getQueryBuilder(): Builder
    {
        return DB::table($this->model->getTable());
    }

    /**
     * @param array|\Closure $condition
     * @return bool
     */
    public function exists($condition): bool
    {
        return $this->getQueryBuilder()->where($condition)->exists();
    }

    /**
     * @param array|\Closure $condition
     * @return bool
     */
    public function doesntExist($condition): bool
    {
        return $this->getQueryBuilder()->where($condition)->doesntExist();
    }

    /**
     * @param array $condition
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $condition, array $values): Model
    {
        return $this->model->updateOrCreate($condition, $values);
    }
}
