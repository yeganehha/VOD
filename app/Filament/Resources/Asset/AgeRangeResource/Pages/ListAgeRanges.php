<?php

namespace App\Filament\Resources\Asset\AgeRangeResource\Pages;

use App\Filament\Resources\Asset\AgeRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgeRanges extends ListRecords
{
    protected static string $resource = AgeRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
