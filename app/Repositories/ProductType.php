<?php

namespace App\Repositories;

use App\Repositories\Contracts\CrudRepository;
use App\Repositories\EloquentRepository;

class ProductType extends EloquentRepository implements CrudRepository
{
    /**
     * The eloquent model.
     *
     * @var array
     */
    protected $eloquent = \App\Models\ProductType::class;

    /**
     * The eloquent model relationships.
     *
     * @var array
     */
    protected $relations = [
        'product' => \App\Models\Product::class
    ];
}
