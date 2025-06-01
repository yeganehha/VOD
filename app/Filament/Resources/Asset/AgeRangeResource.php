<?php

namespace App\Filament\Resources\Asset;

use App\Filament\Resources\Asset\AgeRangeResource\Pages;
use App\Models\Asset\AgeRange;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentClusters\Forms\Cluster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgeRangeResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = AgeRange::class;


    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?string $label = 'محدوده سنی';
    protected static ?string $pluralLabel = 'محدوده‌های سنی';

    protected static ?string $navigationIcon = 'uni-slider-h-range-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('عنوان')
                    ->required(),
                Cluster::make([
                    TextInput::make('from_age')
                        ->label('از')
                        ->prefix('از')
                        ->postfix('سال')
                        ->numeric()
                        ->minValue(0)
                        ->ltr()
                        ->required(),
                    TextInput::make('to_age')
                        ->label('تا')
                        ->prefix('تا')
                        ->postfix('سال')
                        ->numeric()
                        ->minValue(0)
                        ->ltr()
                        ->required(),
                ])->label('محدوده سن مورد نظر'),
                Toggle::make('is_kid')
                    ->label('زیر سن قانونی؟')
                    ->default(false)
                    ->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('عنوان'),
                Tables\Columns\TextColumn::make('from_age')
                    ->sortable()
                    ->label('از سن'),
                Tables\Columns\TextColumn::make('to_age')
                    ->sortable()
                    ->label('تا سن'),
                Tables\Columns\IconColumn::make('is_kid')
                    ->sortable()
                    ->boolean()
                    ->label('زیر سن قانونی؟'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgeRanges::route('/'),
            'create' => Pages\CreateAgeRange::route('/create'),
            'view' => Pages\ViewAgeRange::route('/{record}'),
            'edit' => Pages\EditAgeRange::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
        ];
    }
}
