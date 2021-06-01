<?php

namespace App\Repositories;

use App\Repositories\Contracts\Repository as RepositoryContract;
use Illuminate\Container\Container as Application;
use Illuminate\Log\Logger;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository extends BaseRepository implements RepositoryContract
{
    /**
     * @var Logger
     */
    protected $log;

    /**
     * Repository constructor.
     *
     * @param  Application  $app
     * @param  Logger  $log
     */
    public function __construct(Application $app, Logger $log)
    {
        parent::__construct($app);

        $this->log = $log;
    }

    /**
     * Calling model's default functions.
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    /**
     * Count results of repository
     *
     * @param array $where
     * @param string $columns
     * @return int
     * @throws RepositoryException
     */
    public function count(array $where = [], $columns = '*')
    {
        $this->applyCriteria();
        $this->applyScope();

        if($where) {
            $this->applyConditions($where);
        }

        $result = $this->model->count($columns);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * Retrieve the "sum" result of the query.
     *
     * @param  string  $columns
     * @return int
     */
    public function sum($columns = '*')
    {
        $this->applyCriteria();
        $this->applyScope();

        return $this->model->sum($columns);
    }

    /**
     * Retrieve the "avg" result of the query.
     *
     * @param  string  $columns
     * @return int
     */
    public function avg($columns = '*')
    {
        $this->applyCriteria();
        $this->applyScope();

        return $this->model->avg($columns);
    }

    /**
     * Reset all criteria, scopes and model.
     *
     * @return $this|RepositoryContract
     * @throws RepositoryException
     */
    public function reset()
    {
        $this->resetCriteria();
        $this->resetModel();
        $this->resetScope();

        return $this;
    }

    /**
     * Make apply criteria public.
     *
     * @return Repository
     */
    public function applyCriteria()
    {
        parent::applyCriteria();

        return $this;
    }

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }
}
