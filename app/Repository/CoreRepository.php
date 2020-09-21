<?php


namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 * @package App\Reposiotry
 */
abstract class CoreRepository
{
    /**
     * @var \Laravel\Lumen\Application|mixed
     */
    protected $model;

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return \Laravel\Lumen\Application|mixed
     */
    protected function startCondition()
    {
        return clone $this->model;
    }
}

