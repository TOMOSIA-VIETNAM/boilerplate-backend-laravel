<?php

namespace App\Core\Actions;

/**
 * Interface IBaseAction.
 */
interface IBaseAction
{
    /**
     * Make repository instance
     *
     * @return mixed
     */
    public function makeRepo(): mixed;
}
