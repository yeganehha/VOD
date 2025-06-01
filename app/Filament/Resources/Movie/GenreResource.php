<?php

namespace App\Filament\Resources\Movie;

use App\Filament\Resources\Movie\GenreResource\Pages;
use App\Filament\Resources\Movie\GenreResource\RelationManagers;
use App\Models\Movie\Genre;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;
    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?string $label = 'ژانر فیلم';
    protected static ?string $pluralLabel = 'ژانر‌های فیلم';
    protected static ?string $navigationIcon = 'carbon-categories';

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
                    ->unique('genres' ,'slug' , ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('فقط حروف انگلیسی و عدد و (-,_)')
                    ->label('نامک'),
                Forms\Components\ToggleButtons::make('for_kids')
                    ->label('اختصاصی کودکان')
                    ->required()
                    ->inline()
                    ->options([
                        1 => 'مخصوص کودکان (-18)',
                        0 => 'کلیه رنج های سنی',
                    ])->colors([
                        1 => 'success',
                        0 => 'warning',
                    ])->icons([
                        1 => 'gmdi-child-friendly-o',
                        0 => 'gmdi-family-restroom-o',
                    ]),
                Forms\Components\ToggleButtons::make('hide_from_kids')
                    ->label('مخفی کردن از کودکان (محتوای +18)')
                    ->required()
                    ->inline()
                    ->options([
                        1 => 'مخفی',
                        0 => 'قابل نمایش',
                    ])->colors([
                        1 => 'danger',
                        0 => 'success',
                    ])->icons([
                        1 => 'gmdi-no-adult-content-o',
                        0 => 'heroicon-o-face-smile',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
                Tables\Columns\IconColumn::make('for_kids')
                    ->boolean()
                    ->label('اختصاصی کودکان'),
                Tables\Columns\IconColumn::make('hide_from_kids')
                    ->boolean()
                    ->label('محتوای +18'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListGenres::route('/'),
        ];
    }
}
