<?php

namespace App\Filament\Resources\Movie\EntityResource\RelationManagers;

use App\Enums\Audio;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class MoviesRelationManager extends RelationManager
{
    protected static string $relationship = 'movies';
    protected static ?string $recordTitleAttribute = 'season';
    protected static ?string $title = 'قسمت‌ها / اپیزودها';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('season')
                    ->label('فصل')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Forms\Components\TextInput::make('episode')
                    ->label('قسمت')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Forms\Components\TextInput::make('imdb_rate')
                    ->label('امتیاز IMDb')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->step(0.1),

                Forms\Components\Select::make('main_audio')
                    ->label('زبان محاوره')
                    ->options(Audio::class)
                    ->native(false),

                Forms\Components\Toggle::make('dubbed')
                    ->label('دوبله'),

                Forms\Components\Toggle::make('has_subtitle')
                    ->label('زیرنویس'),

                Forms\Components\Toggle::make('exclusive')
                    ->label('اختصاصی'),

                Forms\Components\DatePicker::make('publish_date')
                    ->label('تاریخ انتشار'),

                Forms\Components\TextInput::make('pro_year')
                    ->label('سال تولید')
                    ->numeric()
                    ->minValue(1300)
                    ->maxValue(now()->year + 1),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('season')
                    ->label('فصل'),

                Tables\Columns\TextColumn::make('episode')
                    ->label('قسمت'),

                Tables\Columns\TextColumn::make('imdb_rate')
                    ->label('امتیاز IMDb'),

                Tables\Columns\TextColumn::make('main_audio')
                    ->label('زبان')
                    ->formatStateUsing(fn($state) => $state?->getLabel() ?? '-'),

                Tables\Columns\IconColumn::make('dubbed')
                    ->label('دوبله')
                    ->boolean(),

                Tables\Columns\IconColumn::make('has_subtitle')
                    ->label('زیرنویس')
                    ->boolean(),

                Tables\Columns\IconColumn::make('exclusive')
                    ->label('اختصاصی')
                    ->boolean(),

                Tables\Columns\TextColumn::make('publish_date')
                    ->label('تاریخ انتشار')
                    ->date('Y/m/d'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('exclusive')->label('اختصاصی'),
                Tables\Filters\TernaryFilter::make('dubbed')->label('دوبله'),
                Tables\Filters\TernaryFilter::make('has_subtitle')->label('زیرنویس'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('افزودن قسمت'),
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
