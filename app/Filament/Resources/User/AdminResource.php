<?php

namespace App\Filament\Resources\User;

use App\Filament\Resources\User\AdminResource\Pages;
use App\Models\User\Admin;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationGroup = 'کاربران';

    protected static ?string $label = 'مدیر و پشتیبان';
    protected static ?string $pluralLabel = 'مدیران و پشتیبانان';

    protected static ?string $navigationIcon = 'eos-admin-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255)
                    ->label('نام'),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255)
                    ->label('نام خانوادگی'),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->unique('admins' ,'username',ignoreRecord: true)
                    ->readOnlyOn('edit')
                    ->ltr()
                    ->label('نام کاربری'),
                Forms\Components\TextInput::make('password')
                    ->ltr()
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->label('رمز عبور'),
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
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->imageEditor()
                    ->inlineLabel()
                    ->directory('avatar/'.now()->format('Y/m/d'))
                    ->avatar()
                    ->label('آواتار'),
                Forms\Components\Select::make('roles')
                    ->label('سطح دسترسی')
                    ->searchable()
                    ->hidden( ! filament()->auth()->user()->can('update_roles_user::admin') )
                    ->multiple()
                    ->preload()
                    ->relationship('roles', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('شناسه')
                    ->sortable(),
                TextColumn::make('first_name')
                    ->label('نام')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('نام خانوادگی')
                    ->searchable(),
                TextColumn::make('username')
                    ->label('نام کاربری')
                    ->searchable(),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'update_roles'
        ];
    }
}
