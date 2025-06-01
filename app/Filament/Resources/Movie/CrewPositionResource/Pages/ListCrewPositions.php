<?php

namespace App\Filament\Resources\Movie\CrewPositionResource\Pages;

use App\Filament\Resources\Movie\CrewPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCrewPositions extends ListRecords
{
    protected static string $resource = CrewPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
