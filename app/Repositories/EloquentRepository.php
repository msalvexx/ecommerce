<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class EloquentRepository
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //instantiate repository
        $this->eloquent = app()->make($this->eloquent);

        if(!empty($this->relations)) {
            //instantiate related repositories
            foreach($this->relations as $variable => $class) {
                $this->{$variable} = app()->make($class);
            }
        }
    }

    /**
     * Create a new model instance.
     *
     * @param  mix  $array
     * @return array
     */
    public function create($array)
    {
        return $this->eloquent->create($array)->toArray();
    }

    /**
     * Returns the first model or creates a new model instance.
     *
     * @param  mix  $array
     * @return array
     */
    public function firstOrCreate($array)
    {
        return $this->eloquent->firstOrCreate($array)->toArray();
    }

    /**
     * Updates a model instance.
     *
     * @param  int  $id
     * @param  mix  $array
     * @return array
     */
    public function update($id, $array)
    {
        return $this->eloquent->find($id)->update($array)->toArray();
    }

    /**
     * Delete a model instance.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->eloquent->findOrFail($id)->delete();
    }

    /**
     * Find a model instance.
     *
     * @param  int  $id
     * @return mix array
     */
    public function find($id)
    {
        return $this->eloquent->findOrFail($id)->toArray();
    }

    /**
     * List all models.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function list($pageSize = 10)
    {
        return $this->eloquent->paginate($pageSize);
    }
}