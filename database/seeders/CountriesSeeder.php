<?php
namespace Database\Seeders;


use App\Models\Asset\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch country data from SimpleLocalize
        $countries = Http::get('https://cdn.simplelocalize.io/public/v1/countries')->json();

        // Fetch Persian names
        $persianNames = Http::get('https://raw.githubusercontent.com/umpirsky/country-list/master/data/fa_IR/country.json')->json();

        // Prepare storage
        $flagDirectory = 'countries';
        Storage::disk('public')->makeDirectory($flagDirectory);
        Storage::disk('public')->makeDirectory($flagDirectory.'/icon');
        Storage::disk('public')->makeDirectory($flagDirectory.'/medium');
        Storage::disk('public')->makeDirectory($flagDirectory.'/normal');
        Storage::disk('public')->makeDirectory($flagDirectory.'/large');

        foreach ($countries as  $country) {
            if ( Country::query()->where('code' , $country['code'])->exists())
                continue;
            $lowerCode = Str::lower($country['code']);
            $persianName = $persianNames[Str::upper($country['code'])] ?? $country['name'];
            try {
                $flagUrl = "https://flagcdn.com/w40/{$lowerCode}.png";
                $flagContent = Http::get($flagUrl)->body();
                Storage::disk('public')->put("{$flagDirectory}/icon/{$lowerCode}.png", $flagContent);
            } catch (\Exception $e) {
                Log::error("Failed to download flag for {$lowerCode} - icon: {$e->getMessage()}");
            }
            try {
                $flagUrl = "https://flagcdn.com/w160/{$lowerCode}.png";
                $flagContent = Http::get($flagUrl)->body();
                Storage::disk('public')->put("{$flagDirectory}/medium/{$lowerCode}.png", $flagContent);
            } catch (\Exception $e) {
                Log::error("Failed to download flag for {$lowerCode} - medium: {$e->getMessage()}");
            }
            try {
                $flagUrl = "https://flagcdn.com/w640/{$lowerCode}.png";
                $flagContent = Http::get($flagUrl)->body();
                Storage::disk('public')->put("{$flagDirectory}/normal/{$lowerCode}.png", $flagContent);
            } catch (\Exception $e) {
                Log::error("Failed to download flag for {$lowerCode} - normal: {$e->getMessage()}");
            }
            try {
                $flagUrl = "https://flagcdn.com/w2560/{$lowerCode}.png";
                $flagContent = Http::get($flagUrl)->body();
                Storage::disk('public')->put("{$flagDirectory}/large/{$lowerCode}.png", $flagContent);
            } catch (\Exception $e) {
                Log::error("Failed to download flag for {$lowerCode} - large: {$e->getMessage()}");
            }
            Country::query()->insert([
                'name' => $persianName ,
                'code' => Str::upper($country['code']) ,
                'flag' => $lowerCode ,
            ]);
        }
    }
}
