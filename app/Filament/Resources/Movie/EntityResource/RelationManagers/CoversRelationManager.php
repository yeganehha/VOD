<?php

namespace App\Filament\Resources\Movie\EntityResource\RelationManagers;

use App\Enums\CoverType;
use App\Enums\RatioType;
use App\Models\Movie\EntityCover;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class CoversRelationManager extends RelationManager
{
    protected static string $relationship = 'covers';
    protected static ?string $recordTitleAttribute = 'cover_type';
    protected static ?string $title = 'کاورها';


    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cover_type')
                    ->label('نوع کاور')
                    ->required()
                    ->options(CoverType::class)
                    ->native(false),

                Forms\Components\Select::make('ratio_type')
                    ->label('نوع نسبت تصویر')
                    ->required()
                    ->options(RatioType::class)
                    ->native(false),

                Forms\Components\FileUpload::make('path')
                    ->label('فایل کاور')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->directory('entity-covers/' . now()->format('Y/m/d')),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cover_type')
                    ->label('نوع کاور')
                    ->formatStateUsing(fn($state) => CoverType::tryFrom($state)?->getLabel()),

                Tables\Columns\TextColumn::make('ratio_type')
                    ->label('نسبت تصویر')
                    ->formatStateUsing(fn($state) => RatioType::tryFrom($state)?->getLabel()),

                Tables\Columns\ImageColumn::make('path')
                    ->label('تصویر')
                    ->height(60)
                    ->square(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('cover_type')
                    ->label('نوع کاور')
                    ->options(CoverType::class),

                Tables\Filters\SelectFilter::make('ratio_type')
                    ->label('نسبت تصویر')
                    ->options(RatioType::class),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('افزودن کاور'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('ویرایش'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف گروهی'),
            ]);
    }
}
