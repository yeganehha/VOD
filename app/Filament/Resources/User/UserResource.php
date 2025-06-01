<?php

namespace App\Filament\Resources\User;

use App\Filament\Resources\User\UserResource\Pages;
use App\Filament\Resources\User\UserResource\RelationManagers;
use App\Models\User\User;
use App\Services\Helper;
use App\Services\Verification\AutoVerification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'کاربران';

    protected static ?string $label = 'بیننده';
    protected static ?string $pluralLabel = 'بینندگان';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->numeric()
                    ->ltr()
                    ->unique('users' ,'phone',ignoreRecord: true)
                    ->rules(['ir_mobile'])
                    ->maxLength(13)
                    ->label('شماره همراه'),
                Forms\Components\TextInput::make('password')
                    ->visibleOn('edit')
                    ->ltr()
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->label('رمز عبور'),
                Forms\Components\TextInput::make('max_profiles')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->ltr()
                    ->label('حداکثر تعداد پروفایل'),
                Forms\Components\ToggleButtons::make('is_block')
                    ->label('وضعیت کاربر')
                    ->inline()
                    ->options([
                        0 => 'کاربر آزاد است.',
                        1 => 'کاربر مسدود است.',
                    ])->colors([
                        0 => 'success',
                        1 => 'danger',
                    ])->icons([
                        0 => FilamentIcon::resolve('forms::components.toggle-buttons.boolean.true') ?? 'heroicon-m-check',
                        1 => FilamentIcon::resolve('forms::components.toggle-buttons.boolean.false') ?? 'heroicon-m-x-mark',
                    ]),
                Forms\Components\Textarea::make('admin_description')
                    ->nullable()
                    ->columnSpanFull()
                    ->rows(5)
                    ->label('توضیحات محرمانه'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('شناسه')
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('شماره همراه')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_block')
                    ->boolean()
                    ->label('کاربر مسدود'),
                Tables\Columns\TextColumn::make('profiles_count')->counts('profiles')
                    ->sortable()
                    ->label('تعداد پروفایل'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->jalaliDateTime('d F Y,  H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])->defaultSort('id' , 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
