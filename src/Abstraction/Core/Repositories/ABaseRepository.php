<?php

namespace CuongDev\Larab\Abstraction\Core\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
     * @return LengthAwarePaginator|Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function getList(array $params = [])
    {
        $model = $this->getModel();
        $model = $model->newQuery();

        if (count($this->getComparableFields()) > 0) {
            $model = $model->where(function ($query) use ($params) {
                /** @var Builder $query */
                foreach ($this->getComparableFields() as $field) {
                    if (!isset($params[$field])) {
                        continue;
                    }

                    if (is_array($params[$field])) {
                        $query->whereIn($field, $params[$field]);
                    } else {
                        $query->where($field, $params[$field]);
                    }
                }
            });
        }

        if (isset($params['with']) && is_array($params['with'])) {
            $model = $model->with($params['with']);
        }

        if (isset($params['keyword']) && count($this->getSearchableFields()) > 0) {
            $model = $model->where(function ($query) use ($params) {
                /** @var Builder $query */
                $searchableFields = $this->getSearchableFields();
                $keyword = '%' . $params['keyword'] . '%';

                foreach ($searchableFields as $field) {
                    $pos = strpos($field, '.');

                    if ($pos !== false) {
                        $fieldArr = explode('.', $field);

                        if (count($fieldArr) >= 2) {
                            $key = array_pop($fieldArr);
                            $relation = implode('.', $fieldArr);

                            $query->orWhereHas($relation, function ($query) use ($params, $key, $keyword) {
                                $query->where($key, 'LIKE', $keyword);
                            });
                        }
                    } else {
                        $query->orWhere($field, 'LIKE', $keyword);
                    }
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

        $model = $this->extendGetList($model, $params);

        if (isset($params['get_one']) && $params['get_one']) {
            return $model->limit($params['limit'])->firstOrFail();
        }

        if (isset($params['get_all']) && $params['get_all']) {
            return $model->limit($params['limit'])->get();
        }

        return $model->paginate($params['limit'], ['*'], $params['page_key'] ?? 'page');
    }

    /**
     * @param $id
     * @param array $params
     * @return LengthAwarePaginator|Builder|Collection|mixed|null
     */
    public function getOne($id, array $params = [])
    {
        /** @var Builder $model */
        $model = $this->getModel();
        $model = $model->where('id', $id);

        if (isset($params['with']) && is_array($params['with'])) {
            $model = $model->with($params['with']);
        }

        return $model->firstOrFail();
    }

    /**
     * @param array $params
     * @return array
     */
    public function deleteMulti(array $params = []): array
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
     * @param array $params
     * @return Builder
     */
    protected function extendGetList(Builder $model, array $params = []): Builder
    {
        return $model;
    }
}
