<?php

namespace Database\Seeders;

use App\Enums\EntityType;
use App\Models\Movie\Entity;
use App\Models\Movie\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $entities = Entity::all();

        foreach ($entities as $entity) {
            if ($entity->type === EntityType::Movie) {
                Movie::query()->create([
                    'entity_id' => $entity->id,
                    'is_high_definition' => (bool) rand(0, 1),
                    'age_range_id' => $entity->age_range_id,
                    'main_audio' => $entity->main_audio,
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
            }

            if ($entity->type == EntityType::Series ) {
                $movieCount = rand(3, 7);
                for ($i = 0; $i < $movieCount; $i++) {
                    Movie::query()->create([
                        'entity_id' => $entity->id,
                        'is_high_definition' => (bool) rand(0, 1),
                        'age_range_id' => $entity->age_range_id,
                        'main_audio' => $entity->main_audio,
                        'description' => $entity->about_movie . " - Episode " . ($i + 1),
                        'description_en' => $entity->about_movie_en . " - Episode " . ($i + 1),
                        'dubbed' => (bool) rand(0, 1),
                        'duration' => rand(20, 60),
                        'exclusive' => $entity->exclusive,
                        'is_multi_audio' => (bool) rand(0, 1),
                        'has_subtitle' => (bool) rand(0, 1),
                        'imdb_rate' => round(mt_rand(65, 90) / 10, 1),
                        'publish_date' => now()->subDays(rand(10, 350)),
                        'pro_year' => verta()->year,
                        'episode' => ($i + 1),
                        'season' => 1,
                    ]);
                }
            }

            if ($entity->type == EntityType::MultiSeasonSeries ) {
                $SeasonCount = rand(1, 4);
                $movieCount = rand(3, 7);
                for ($j = 0; $j < $SeasonCount; $j++) {
                    for ($i = 0; $i < $movieCount; $i++) {
                        $publishDate = now()->subDays(rand(10, 365));
                        Movie::query()->create([
                            'entity_id' => $entity->id,
                            'is_high_definition' => (bool) rand(0, 1),
                            'age_range_id' => $entity->age_range_id,
                            'main_audio' => $entity->main_audio,
                            'description' => $entity->about_movie . " - Episode " . ($i + 1) . " - Season " . ($j + 1) ,
                            'description_en' => $entity->about_movie_en . " - Episode " . ($i + 1). " - Season " . ($j + 1) ,
                            'dubbed' => (bool)rand(0, 1),
                            'duration' => rand(20, 60),
                            'exclusive' => $entity->exclusive,
                            'is_multi_audio' => (bool)rand(0, 1),
                            'has_subtitle' => (bool) rand(0, 1),
                            'imdb_rate' => round(mt_rand(65, 90) / 10, 1),
                            'publish_date' => $publishDate,
                            'pro_year' => verta($publishDate)->year,
                            'episode' => ($i + 1),
                            'season' => ($j + 1),
                        ]);
                    }
                }
            }
        }
    }
}
