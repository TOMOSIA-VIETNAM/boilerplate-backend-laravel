<?php

namespace App\Actions;

use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseAction implements IBaseAction
{
    protected $repo;

    /**
     * Specify Repository class name.
     *
     * @return mixed
     */
    abstract public function repo(): mixed;

    /**
     * BaseAction constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->makeRepo();
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function makeRepo(): mixed
    {
        $repo = app()->make($this->repo());

        return $this->repo = $repo;
    }
}
