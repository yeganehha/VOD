<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use BladeUI\Icons\Factory;

class FetchAllSVGFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-all-svg-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get All SVG Files for Search';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $icons = cache()->remember('listOfAllIconFiles' , Carbon::now()->addDays(2) , function (){
            $sets = app(Factory::class)->all();

            $files = [];
            foreach ($sets as $set) {
                $prefix = $set['prefix'];
                foreach ($set['paths'] as $path) {
                    foreach (File::allFiles($path) as $file) {
                        if ($file->getExtension() !== 'svg') {
                            continue;
                        }
                        $files[] = $prefix . '-' . str($file->getPathname())
                                ->after($path . DIRECTORY_SEPARATOR)
                                ->replace(DIRECTORY_SEPARATOR, '.')
                                ->basename('.svg')
                                ->toString();
                    }
                }
            }
            return $files;
        });
        $this->output->success(count($icons) . ' icons found.');
    }

}
