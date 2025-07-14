<?php

namespace App\Repositories\Movie;

use App\Enums\EntityType;
use App\Enums\PublishStatus;
use App\Models\Movie\Movie;
use App\Traits\DynamicRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static Collection<Movie> lastItemslastItems($item = 1);
 * @method static MovieRepository futureRelease();
 * @method static MovieRepository series();
 * @method static MovieRepository movie();
 * @method static MovieRepository singleShow($entitySlug , $episode, $season);
 * @method static MovieRepository searchByTag(array $tags,string|null $queryString = null);
 * @method static MovieRepository filterByType(array|EntityType $value)
 * @method static MovieRepository filterByLanguage(array|string $values)
 * @method static MovieRepository filterByAgeRange(array|string $value)
 * @method static MovieRepository filterByCountry(array|string $values)
 * @method static MovieRepository filterByGenre(array|string $values)
 * @method static MovieRepository productOfYear(int $year)
 */
class MovieRepository
{
    use DynamicRepository;
    protected ?string $modelClass = Movie::class;
    public function activeFilter(): void
    {
        $this->query
            ->groupBy('entity_id')
            ->orderByDesc('publish_date')
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
    private function _movie(): void
    {
        $this->query
            ->whereHas('entity' , fn(Builder $builder) => $builder->whereNotIn('type' , collect(EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray()));
    }
    private function _singleShow($entitySlug , $episode, $season): void
    {
        $this->query
            ->with(['entity'  ,'covers' , 'entity.covers', 'entity.genres', 'entity.countries'])
            ->wherehas('entity' , fn($builder) => $builder->where('slug' , $entitySlug))
            ->where('episode' , $episode)
            ->where('season' , $season);
    }
    private function _productOfYear(int $year): void
    {
        $this->query->where('pro_year' , $year);
    }
    private function _searchByTag(array $tags , ?string $queryString = null): void
    {
        $this->query = null;
        $this->query = app($this->modelClass)::query();
        $this->query
            ->with(['entity'  ,'covers' , 'entity.covers', 'entity.genres']);
        $this->activeFilter();
        foreach (get_class_methods($this) as $method) {
            if( str($method)->startsWith('_filterBy') ){
                $this->$method($tags);
            }
        }
        if ( $queryString )
            $this->query->whereLike('title' , '%'.$queryString.'%');
    }
    private function _filterByType(array|EntityType $value): void
    {
        if ( is_array($value) ){
            $value = collect($value)->filter(fn($item) => EntityType::tryFrom($item) != null )->first();
        }
        if( $value ) {
            $this->query->when($value == EntityType::Movie->value,
                fn($builder) => $builder->wherehas('entity', fn($builder) => $builder->whereNotIn('type', collect(EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray())),
                fn($builder) => $builder->wherehas('entity', fn($builder) => $builder->whereIn('type', collect(EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray()))
            );
        }
    }
    private function _filterByLanguage(array|string $values): void
    {
        if ( ! is_array($values) )
            $values = [$values];
        foreach ($values as $value){
            if ( $value == 'is_dubbed')
                $this->query->where('dubbed' , true);
            elseif ( $value == 'fa_sub')
                $this->query->where('has_subtitle' , true);
            elseif ( $value == 'is_multilingual')
                $this->query->where('is_multi_audio' , true);
        }
    }
    private function _filterByAgeRange(array|string $value): void
    {
        if ( is_array($value) ){
            if ( count($value) == 2 and is_int($value[0]) and is_int($value[1])){
                $value = 'age_between_' . $value[0].'_and_'.$value[1];
            } else {
                $value = collect($value)->filter(
                    fn($item) => str($item)->startsWith('age_between_')
                )->first();
            }
        }
        if ( str($value)->startsWith('age_between_') ){
            list($from,$to) = explode('-', str_replace('age_between_' , '' , str_replace('_and_' , '-' , $value)));
            $this->query->whereHas('ageRange',
                fn($builder) => $builder->where('from_age' , $from)->where('to_age' ,$to)
            );
        }
    }
    private function _filterByCountry(array|string $values): void
    {
        if ( ! is_array($values) ){
            $values = [$values];
        }
        $values = collect($values);
        if( (clone $values)->filter(fn($item) => $item == 'other_country')->count() > 0){
            $values = \App\Repositories\Movie\CountryRepository::getAll(14)->pluck('code')->toArray();
            $this->query->whereHas('entity.countries', fn($builder) => $builder->whereNotIn('code' , $values));
            return;
        }
        if ((clone $values)->filter(fn($item) => str($item)->contains('_') and strpos($item,'_') == 2)->count() > 0){
            $values = $values->map(fn($item) => explode('_',$item)[0])->toArray();
            $this->query->whereHas('entity.countries', fn($builder) => $builder->whereIn('code' , $values));
        }
    }
    private function _filterByGenre(array|string $values): void
    {
        if ( ! is_array($values) )
            $values = [$values];
        $values = collect($values)
            ->filter(fn($item) => ! (
                str($item)->contains('_') or
                str($item)->startsWith('age_between_') or
                in_array($item,['is_dubbed', 'fa_sub', 'is_multilingual']) or
                EntityType::tryFrom($item) != null or
                empty($item)
            ));
        if ($values->count() > 0)
        {
            $this->query->whereHas('entity.genres', fn($builder) => $builder->whereIn('slug' , $values->map(
                fn($item) => strtolower(
                    preg_replace(
                        '/(?>[A-Z]?[a-z]+|[A-Z]+(?=[A-Z][a-z]|[^A-Za-z])|[^A-Za-z]+)\K(?!$)/',
                        '-',
                        $item
                    )
                )
            )->values()));
        }
    }
}
