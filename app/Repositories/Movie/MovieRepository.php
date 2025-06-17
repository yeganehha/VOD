<?php

namespace App\Repositories\Movie;

use App\Enums\EntityType;
use App\Enums\PublishStatus;
use App\Models\Movie\Movie;
use App\Traits\DynamicRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method Collection<Movie> lastItemslastItems($item = 1);
 * @method MovieRepository futureRelease();
 * @method MovieRepository series();
 * @method MovieRepository singleShow($entitySlug , $episode, $season);
 */
class MovieRepository
{
    use DynamicRepository;
    protected ?string $modelClass = Movie::class;
    public function activeFilter(): void
    {
        $this->query
            ->with(['entity'  , 'entity.covers', 'entity.genres'])
            ->where('publish_date' , '<=', now()->addDays(7))
            ->whereHas('entity' , fn(Builder $builder) => $builder->where('publish_status' , PublishStatus::Publish->value));
    }

    private function _futureRelease(): void
    {
        // TODO: uncomment this files
//        $this->query
//            ->where('publish_date' , '>=', now()->subDays(2));
    }
    private function _series(): void
    {
        $this->query
            ->whereHas('entity' , fn(Builder $builder) => $builder->whereIn('type' , collect(EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray()));
    }
    private function _singleShow($entitySlug , $episode, $season): void
    {
        $this->query
            ->with(['entity'  ,'covers' , 'entity.covers', 'entity.genres', 'entity.countries'])
            ->wherehas('entity' , fn($builder) => $builder->where('slug' , $entitySlug))
            ->where('episode' , $episode)
            ->where('season' , $season);
    }
}
