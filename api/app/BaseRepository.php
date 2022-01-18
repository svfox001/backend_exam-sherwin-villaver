<?php

namespace App;

use App\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->orderBy('created_at','desc')->get($columns);
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function allWithTrashed(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->withTrashed()->get($columns);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find model by id.
     *
     * @param string $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        string $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findTrashedById(string $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findOnlyTrashedById(string $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    /**
     * Update existing model.
     *
     * @param string $modelId
     * @param array $payload
     * @return Model
     */
    public function update(string $modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);
        $model->update($payload);
        return $model;
    }

    /**
     * Delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function deleteById(string $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function restoreById(string $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function permanentlyDeleteById(string $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }
}