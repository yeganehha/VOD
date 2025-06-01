<?php

namespace App\Filament\Resources\User\AdminResource\Pages;

use App\Filament\Resources\User\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
