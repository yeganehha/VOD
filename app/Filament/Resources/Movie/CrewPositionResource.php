<?php

namespace App\Filament\Resources\Movie;

use App\Filament\Resources\Movie\CrewPositionResource\Pages;
use App\Filament\Resources\Movie\CrewPositionResource\RelationManagers;
use App\Models\Movie\CrewPosition;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CrewPositionResource extends Resource
{
    protected static ?string $model = CrewPosition::class;

    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?string $label = 'سمت‌ اعضای تیم سازنده';
    protected static ?string $pluralLabel = 'سمت‌های اعضای تیم سازنده';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->ltr()
                    ->suffixAction(
                        Action::make('addSlug')
                            ->icon('bi-stars')
                            ->tooltip('ساخت نامک')
                            ->action(function (Set $set, Forms\Get $get) {
                                $set('slug', Str::slug($get('title')) );
                            })
                    )
                    ->rules(['alpha_dash:ascii'])
                    ->unique('crew_positions' ,'slug' , ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('فقط حروف انگلیسی و عدد و (-,_)')
                    ->label('نامک'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
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
            'index' => Pages\ListCrewPositions::route('/'),
        ];
    }
}
