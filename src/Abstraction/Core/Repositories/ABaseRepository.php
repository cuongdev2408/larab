<?php

namespace CuongDev\Larab\Abstraction\Core\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Prettus\Repository\Eloquent\BaseRepository;

abstract class ABaseRepository extends BaseRepository
{
    protected $comparableFields = [];
    protected $searchableFields = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract function model(): string;

    /**
     * @return array
     */
    public function getComparableFields(): array
    {
        return $this->comparableFields;
    }

    /**
     * @param array $comparableFields
     */
    public function setComparableFields(array $comparableFields)
    {
        $this->comparableFields = $comparableFields;
    }

    /**
     * @return array
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    /**
     * @param array $searchableFields
     */
    public function setSearchableFields(array $searchableFields)
    {
        $this->searchableFields = $searchableFields;
    }

    /**
     * @param array $params
     * @return array|false[]|LengthAwarePaginator|\Illuminate\Database\Query\Builder[]|Collection|LazyCollection|Builder[]
     */
    public function getList($params = [])
    {
        /** @var Builder $model */
        $model = $this->getModel()->where(function ($query) use ($params) {
            /** @var Builder $query */
            if (count($this->comparableFields) > 0) {
                foreach ($this->comparableFields as $field) {
                    if (!isset($params[$field])) {
                        continue;
                    }

                    if (is_array($params[$field])) {
                        $query->whereIn($field, $params[$field]);
                    } else {
                        $query->where($field, $params[$field]);
                    }
                }
            }
        });

        if (isset($params['with']) && is_array($params['with'])) {
            $model = $this->processEagerLoading($model, $params['with']);
        }

        if (isset($params['keyword'])) {
            $model = $model->where(function ($query) use ($params) {
                /** @var Builder $query */
                foreach ($this->comparableFields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $params[$field] . '%');
                }
            });
        }

        if (isset($params['ids']) && is_array($params['ids'])) {
            $model = $model->whereIn('id', $params['ids']);
        }

        if (isset($params['sort']) && is_array($params['sort'])) {
            foreach ($params['sort'] as $orderBy => $orderDirection) {
                $model = $model->orderBy($orderBy, $orderDirection);
            }
        }

        if (isset($params['getAll']) && $params['getAll']) {
            return $model->limit($params['limit'])->get();
        }

        return $model->paginate($params['limit'], ['*'], isset($params['pageKey']) ? $params['pageKey'] : 'page');
    }

    /**
     * @param array $params
     * @return array
     */
    public function deleteMulti($params = []): array
    {
        $res = [
            'deleted'     => [],
            'not_deleted' => [],
            'not_found'   => [],
        ];

        return $res;
    }

    /**
     * @param Builder $model
     * @param array $with
     * @return Builder
     */
    protected function processEagerLoading(Builder $model, $with = []): Builder
    {
        /** @var Builder $model */
        $model = $model->with($with);
        return $model;
    }
}
