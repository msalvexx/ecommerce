<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Closure;

/**
 * HasFilter
 */
trait HasCategoryFilter
{
    /**
     * The name resolver callback.
     *
     * @var \Closure
     */
    protected static $categoryResolver;


    /**
     * Set the name resolver callback.
     *
     * @param  \Closure  $resolver
     * @return void
     */
    public static function categoryResolver(Closure $resolver)
    {
        static::$categoryResolver = $resolver;
    }

    /**
     * Resolve the current page or return the default value.
     *
     * @param  string  $pageName
     * @param  int  $default
     * @return int
     */
    public static function resolveCategoryQuery($queryName = 'q', $default = null)
    {
        if (isset(static::$categoryResolver)) {
            return call_user_func(static::$categoryResolver, $default);
        }
        return $default;
    }

    /**
     * Scope a category that can be used.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mix $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory(Builder $builder, $category = null)
    {
        $category = $category ?: static::resolveCategoryQuery();

        if(isset($category)) {
            $builder->whereHas($this->categoryRelation, function($b) use ($category){
                $b->where('name', 'like', $category);
            });
        }

        return $builder;
    }
}
