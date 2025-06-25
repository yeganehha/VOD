<?php

namespace Database\Seeders;

use App\Enums\CoverType;
use App\Enums\EntityType;
use App\Enums\RatioType;
use App\Models\Movie\Entity;
use App\Models\Movie\EntityCover;
use App\Models\Movie\Movie;
use App\Models\Movie\MovieCover;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{

    private array $images = [] ;
    private function makeMovieCovers($movieId): void
    {
        foreach ( [RatioType::R_21_9 , RatioType::R_16_9, RatioType::R_1_1, RatioType::R_9_16, RatioType::R_3_4, RatioType::R_3_5  ] as $case ){
            $source = collect(optional($this->images)[$case->value] ?? [])->random();
            $destination = 'movie-covers/'. now()->format('Y/m/d').'/'.  Str::uuid() .'.' . pathinfo($source, PATHINFO_EXTENSION) ;
            copy($source , storage_path('app/public/'. $destination)) ;
            MovieCover::query()->create([
                'movie_id' => $movieId ,
                'ratio_type' => $case->value ,
                'cover_type' => CoverType::Image,
                'path' => $destination
            ]);
        }
    }
    public function run(): void
    {
        $entities = Entity::all();
        foreach ( glob(public_path('assets/theme/images/*.*')) as $filename ) {
            list($width, $height, $type, $attr) = getimagesize($filename);
            if( $height == 0 )
                continue;
            $imgRatio = ((float)$width / (float)$height);
            $selectedRatio = PHP_INT_MAX ;
            $selectedRatioCase = null;
            foreach ( RatioType::cases() as $case ){
                if ( abs($case->division() - $imgRatio) <= $selectedRatio){
                    $selectedRatio = abs($case->division() - $imgRatio);
                    $selectedRatioCase = $case;
                }
            }
            $this->images[$selectedRatioCase->value][] = $filename;
        }
        foreach ( RatioType::cases() as $case ){
            $selectedRatio = PHP_INT_MAX ;
            $selectedRatioImage = null;
            foreach ( glob(public_path('assets/theme/images/*.*')) as $filename ) {
                list($width, $height, $type, $attr) = getimagesize($filename);
                if( $height == 0 )
                    continue;
                $imgRatio = ((float)$width / (float)$height);
                if ( abs($case->division() - $imgRatio) <= $selectedRatio){
                    $selectedRatio = abs($case->division() - $imgRatio);
                    $selectedRatioImage = $filename;
                }
            }
            $this->images[$case->value][] = $selectedRatioImage;
        }
        Storage::makeDirectory('public/entity-covers/');
        Storage::makeDirectory('public/entity-covers/' . now()->format('Y'));
        Storage::makeDirectory('public/entity-covers/' . now()->format('Y/m'));
        Storage::makeDirectory('public/entity-covers/' . now()->format('Y/m/d'));
        Storage::makeDirectory('public/movie-covers/');
        Storage::makeDirectory('public/movie-covers/' . now()->format('Y'));
        Storage::makeDirectory('public/movie-covers/' . now()->format('Y/m'));
        Storage::makeDirectory('public/movie-covers/' . now()->format('Y/m/d'));
        foreach ($entities as $entity) {
            foreach ( RatioType::cases() as $case ){
                if ( count(optional($this->images)[$case->value] ?? [] ) == 0  )
                    dd($case->value);
                $source = collect(optional($this->images)[$case->value] ?? [])->random();
                $destination = 'entity-covers/'. now()->format('Y/m/d').'/'.  Str::uuid() .'.' . pathinfo($source, PATHINFO_EXTENSION) ;
                copy($source , storage_path('app/public/'. $destination)) ;
                EntityCover::query()->create([
                    'entity_id' => $entity->id ,
                    'ratio_type' => $case->value ,
                    'cover_type' => CoverType::Image,
                    'path' => $destination
                ]);
            }
            if ($entity->type === EntityType::Movie) {
                $movie = Movie::query()->create([
                    'entity_id' => $entity->id,
                    'is_high_definition' => (bool) rand(0, 1),
                    'age_range_id' => $entity->age_range_id,
                    'main_audio' => $entity->main_audio,
                    'title' => $entity->title,
                    'title_en' => $entity->title_en,
                    'description' => $entity->about_movie,
                    'description_en' => $entity->about_movie_en,
                    'dubbed' => (bool) rand(0, 1),
                    'duration' => rand(75, 150),
                    'exclusive' => $entity->exclusive,
                    'is_multi_audio' => (bool) rand(0, 1),
                    'has_subtitle' => (bool) rand(0, 1),
                    'imdb_rate' => round(mt_rand(60, 95) / 10, 1),
                    'publish_date' => now()->subDays(rand(10, 300)),
                    'pro_year' => $entity->pro_year,
                    'season' => 1,
                    'episode' => 1,
                ]);
                $this->makeMovieCovers($movie->id);
            }

            if ($entity->type == EntityType::Series ) {
                $movieCount = rand(3, 7);
                for ($i = 0; $i < $movieCount; $i++) {
                    $movie = Movie::query()->create([
                        'entity_id' => $entity->id,
                        'is_high_definition' => (bool) rand(0, 1),
                        'age_range_id' => $entity->age_range_id,
                        'main_audio' => $entity->main_audio,
                        'title' => $entity->title. " - Episode " . ($i + 1),
                        'title_en' => $entity->title_en. " - Episode " . ($i + 1),
                        'description' => fake('fa')->paragraph ,
                        'description_en' => fake('en')->paragraph ,
                        'dubbed' => (bool) rand(0, 1),
                        'duration' => rand(20, 120),
                        'exclusive' => $entity->exclusive,
                        'is_multi_audio' => (bool) rand(0, 1),
                        'has_subtitle' => (bool) rand(0, 1),
                        'imdb_rate' => round(mt_rand(65, 90) / 10, 1),
                        'publish_date' => now()->subDays(rand(10, 350)),
                        'pro_year' => verta()->year,
                        'episode' => ($i + 1),
                        'season' => 1,
                    ]);
                    $this->makeMovieCovers($movie->id);
                }
            }

            if ($entity->type == EntityType::MultiSeasonSeries ) {
                $SeasonCount = rand(1, 4);
                $movieCount = rand(3, 7);
                for ($j = 0; $j < $SeasonCount; $j++) {
                    for ($i = 0; $i < $movieCount; $i++) {
                        $publishDate = now()->subDays(rand(10, 365));
                        $movie = Movie::query()->create([
                            'entity_id' => $entity->id,
                            'is_high_definition' => (bool) rand(0, 1),
                            'age_range_id' => $entity->age_range_id,
                            'main_audio' => $entity->main_audio,
                            'description' => $entity->about_movie . " - Episode " . ($i + 1) . " - Season " . ($j + 1) ,
                            'description_en' => $entity->about_movie_en . " - Episode " . ($i + 1). " - Season " . ($j + 1) ,
                            'dubbed' => (bool)rand(0, 1),
                            'duration' => rand(20, 120),
                            'exclusive' => $entity->exclusive,
                            'is_multi_audio' => (bool)rand(0, 1),
                            'has_subtitle' => (bool) rand(0, 1),
                            'imdb_rate' => round(mt_rand(65, 90) / 10, 1),
                            'publish_date' => $publishDate,
                            'pro_year' => verta($publishDate)->year,
                            'episode' => ($i + 1),
                            'season' => ($j + 1),
                        ]);
                        $this->makeMovieCovers($movie->id);
                    }
                }
            }
        }
    }
}
