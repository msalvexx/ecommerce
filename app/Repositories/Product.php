<?php

namespace App\Repositories;

use App\Repositories\Contracts\CrudRepository;
use App\Repositories\EloquentRepository;
use Arr;

class Product extends EloquentRepository implements CrudRepository
{
    /**
     * The eloquent model.
     *
     * @var array
     */
    protected $eloquent = \App\Models\Product::class;

    /**
     * The eloquent model relationships.
     *
     * @var array
     */
    protected $relations = [
        'type' => \App\Models\ProductType::class
    ];

    /**
     * List all models.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function list($pageSize = 10)
    {
        return $this->eloquent->applyFilters()->applySort()->paginate($pageSize);
    }

    /**
     * Create a new model instance.
     *
     * @param  mix  $array
     * @return array
     */
    public function create($array)
    {
        //Set product type relation
        $type = $this->type->firstOrCreate(['name' => $array['type']]);
        $this->eloquent->type()->associate($type);

        //Fill all attributes
        $eloquent = $this->eloquent->fill($array);

        $eloquent->save();

        return $eloquent;
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
        $eloquent = $this->eloquent->find($id);

        //Set product type relation if needs
        if(Arr::has($array, 'type')) {
            $type = $this->type->firstOrCreate(['name' => $array['type']]);
            $eloquent->type()->associate($type);
            unset($array['type']);
        }

        $eloquent->update($array);

        return $eloquent->toArray();
    }
}
