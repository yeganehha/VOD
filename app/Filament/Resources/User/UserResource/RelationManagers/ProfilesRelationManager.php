<?php

namespace App\Filament\Resources\User\UserResource\RelationManagers;

use App\Models\User\Profile;
use App\Models\User\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilesRelationManager extends RelationManager
{
    protected static string $relationship = 'profiles';
    protected static bool $isLazy = false;
    protected static ?string $title = 'پروفایل';
    protected static ?string $label = 'پروفایل';
    protected static ?string $pluralLabel = 'پروفایل‌ها';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('عنوان پروفایل')
                    ->maxLength(255),
                Forms\Components\Select::make('ageRange')
                    ->label('محدوده سنی')
                    ->relationship('ageRange', 'title')
                    ->searchable(['title'])
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('عنوان پروفایل'),
                Tables\Columns\TextColumn::make('ageRange.title')->label('محدوده سنی'),
                Tables\Columns\IconColumn::make('ageRange.is_kid')
                    ->boolean()
                    ->label('زیر سن قانونی'),
                Tables\Columns\IconColumn::make('main_user')
                    ->boolean()
                    ->label('پرفایل اصلی'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->jalaliDateTime('d F Y,  H:i:s')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->hidden(fn() => $this->getRelationship()->getParent()->max_profiles  <= $this->getRelationship()->getParent()->profiles()->count()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->hidden(fn(Profile $profile) => $profile->main_user ),
            ])
            ->defaultSort('id' , 'desc');
    }
}
