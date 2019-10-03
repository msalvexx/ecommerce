<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Closure;

/**
 * IsSortable
 */
trait IsSortable
{
/**
     * The sort resolver callback.
     *
     * @var \Closure
     */
    protected static $sortResolver;

    /**
     * Set the sort resolver callback.
     *
     * @param  \Closure  $resolver
     * @return void
     */
    public static function sortResolver(Closure $resolver)
    {
        static::$sortResolver = $resolver;
    }

    /**
     * Resolve the current page or return the default value.
     *
     * @param  string  $pageName
     * @param  int  $default
     * @return int
     */
    public static function resolveSort($queryName = 'sort', $default = null)
    {
        if (isset(static::$sortResolver)) {
            return call_user_func(static::$sortResolver, $default);
        }

        return $default;
    }

    /**
     * Scope a sort.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param mix $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplySort(Builder $builder, $sort = null)
    {
        $sort = $sort ?: static::resolveSort();
        $columns = explode(',', $sort);

        foreach($columns as $column) {
            $field = explode(':', $column);

            //Check if column attribute exists
            if(count($field) != 2 || !in_array($field[0], $this->getVisible())) {
                continue;
            }

            $field[1] = $field[1] == 'desc' ? 'desc': 'asc';
            $builder->orderBy($field[0], $field[1]);
        }

        return $builder;
    }
}
