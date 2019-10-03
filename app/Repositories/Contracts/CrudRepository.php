<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface CrudRepository
{
    /**
     * Create a new model instance.
     *
     * @param  mix  $array
     * @return array
     */
    public function create($array);

    /**
     * Returns the first model or creates a new model instance.
     *
     * @param  mix  $array
     * @return array
     */
    public function firstOrCreate($array);

    /**
     * Updates a model instance.
     *
     * @param  int  $id
     * @param  mix  $array
     * @return array
     */
    public function update($id, $array);

    /**
     * Delete a model instance.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id);

    /**
     * List all models.
     *
     * int $pageSize
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function list($pageSize = 10);

    /**
     * Find a model instance.
     *
     * @param  int  $id
     * @return mix array
     */
    public function find($id);
}