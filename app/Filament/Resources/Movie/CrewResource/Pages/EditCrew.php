<?php

namespace App\Filament\Resources\Movie\CrewResource\Pages;

use App\Filament\Resources\Movie\CrewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCrew extends EditRecord
{
    protected static string $resource = CrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
