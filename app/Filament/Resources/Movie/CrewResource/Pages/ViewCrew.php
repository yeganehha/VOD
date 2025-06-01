<?php

namespace App\Filament\Resources\Movie\CrewResource\Pages;

use App\Filament\Resources\Movie\CrewResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCrew extends ViewRecord
{
    protected static string $resource = CrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
