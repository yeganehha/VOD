<?php

namespace App\Filament\Resources\Asset\AgeRangeResource\Pages;

use App\Filament\Resources\Asset\AgeRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAgeRange extends ViewRecord
{
    protected static string $resource = AgeRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
