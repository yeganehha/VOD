<?php

namespace App\Repositories\Movie;

use App\Enums\EntityType;
use App\Enums\PublishStatus;
use App\Models\Movie\Movie;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method Builder query();
 * @method Collection<Movie> lastItemslastItems($item = 1);
 * @method MovieRepository futureRelease();
 * @method MovieRepository series();
 */
class MovieRepository
{
    private static $instance = null;
    private $query;

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
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        $method = '_'.str($method)->camel();
        if ( ! method_exists(self::$instance, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        self::$instance->activeMovieFilter();
        self::$instance->$method(...$parameters);
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

        self::$instance->activeMovieFilter();
        $this->$method(...$parameters);
        return self::$instance;
    }

    private function __construct(){
        $this->query = Movie::query();
    }


    private function activeMovieFilter(): void
    {
        $this->query
            ->with(['entity'  , 'entity.covers', 'entity.genres'])
            ->where('publish_date' , '<=', now()->addDays(7))
            ->whereHas('entity' , fn(Builder $builder) => $builder->where('publish_status' , PublishStatus::Publish->value));
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function lastItems($limit = 1): Collection
    {
        return $this->query->orderBy('publish_date', 'desc')->take($limit)->get();
    }

    private function _futureRelease(): void
    {
//        $this->query
//            ->where('publish_date' , '>=', now()->subDays(2));
    }
    private function _series(): void
    {
        $this->query
            ->whereHas('entity' , fn(Builder $builder) => $builder->whereIn('type' , collect(EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray()));
    }
}
