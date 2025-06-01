<?php

namespace App\Filament\Resources\User\AdminResource\Pages;

use App\Filament\Resources\User\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
