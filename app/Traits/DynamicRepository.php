<?php

namespace App\Traits;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait DynamicRepository
{
    protected static $instance = null;
    protected $query;

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        self::$instance = new static();
        $method = '_'.str($method)->camel();
        if ( ! method_exists(self::$instance, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        self::$instance->$method(...$parameters);
        return self::$instance;
    }
    public static function init(): static
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = $this;
        }
        $method = '_'.str($method)->camel();
        if ( ! method_exists($this, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $this->$method(...$parameters);
        return self::$instance;
    }

    private function __construct(){
        $this->query = app($this->modelClass)::query();
        if ( method_exists($this, 'activeFilter'))
            $this->activeFilter();
    }


    public function query(): Builder
    {
        return $this->query;
    }

    public function lastItems($limit = 1): Collection
    {
        return $this->query->orderBy('publish_date', 'desc')->take($limit)->get();
    }

}
