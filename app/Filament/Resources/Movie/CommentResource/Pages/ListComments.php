<?php

namespace App\Filament\Resources\Movie\CommentResource\Pages;

use App\Enums\PublishStatus;
use App\Filament\Resources\Movie\CommentResource;
use App\Models\Movie\Comment;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
