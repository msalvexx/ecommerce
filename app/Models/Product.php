<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasFilter;
use App\Traits\HasCategoryFilter;
use App\Traits\IsSortable;

class Product extends Model
{
    use SoftDeletes, IsSortable, HasFilter, HasCategoryFilter;

    /**
     * The category relation used to filter.
     *
     * @var array
     */
    protected $categoryRelation = 'type';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'type'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'product_type_id',
        'brand',
        'amount',
        'stock'
    ];

    /**
     * The attributes that are visible at array.
     *
     * @var array
     */
    protected $visible = [
        'name',
        'type',
        'brand',
        'amount',
        'stock',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the type associated with this product.
     */
    public function type()
    {
        return $this->belongsTo(\App\Models\ProductType::class, 'product_type_id');
    }

    /**
     * Scope a filter that can be used.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mix $name
     * @param mix $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyFilters(Builder $builder, $category = null, $filter = null)
    {
        return $builder->category()->filter();
    }
}
