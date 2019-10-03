<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $visible = [
        'name',
    ];

    /**
     * Get the products associated with this model.
     */
    public function products()
    {
        return $this->hasMany(App\Models\Product::class);
    }
}
