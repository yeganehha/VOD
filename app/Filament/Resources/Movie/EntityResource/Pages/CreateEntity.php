<?php

namespace App\Filament\Resources\Movie\EntityResource\Pages;

use App\Filament\Resources\Movie\EntityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEntity extends CreateRecord
{
    protected static string $resource = EntityResource::class;
}
