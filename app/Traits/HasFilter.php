<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Closure;

/**
 * HasFilter
 */
trait HasFilter
{
    /**
     * The name resolver callback.
     *
     * @var \Closure
     */
    protected static $nameResolver;

    /**
     * The filter resolver callback.
     *
     * @var \Closure
     */
    protected static $filterResolver;

    /**
     * Set the filter resolver callback.
     *
     * @param  \Closure  $resolver
     * @return void
     */
    public static function filterResolver(Closure $resolver)
    {
        static::$filterResolver = $resolver;
    }

     /**
     * Resolve the current page or return the default value.
     *
     * @param  string  $pageName
     * @param  int  $default
     * @return int
     */
    public static function resolveFilterQuery($queryName = 'filter', $default = null)
    {
        if (isset(static::$filterResolver)) {
            return call_user_func(static::$filterResolver, $default);
        }
        return $default;
    }

    /**
     * Scope a filter that can be used.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mix $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $filter = null)
    {
        $filter = $filter ?: static::resolveFilterQuery();
        $columns = explode(',', $filter);

        foreach($columns as $column) {
            $field = explode(':', $column);

            //Check if column attribute exists
            if(count($field) != 2 || !in_array($field[0], $this->getVisible())) {
                continue;
            }

            return $builder->where($field[0], 'like',  "%$field[1]%");
        }

        return $builder;
    }
}
