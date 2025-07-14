<?php

namespace App\Filament\Resources\Movie\EntityResource\RelationManagers;

use App\Enums\Audio;
use App\Enums\EntityType;
use App\Models\Movie\Entity;
use App\Models\Movie\Movie;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class MoviesRelationManager extends RelationManager
{
    protected static string $relationship = 'movies';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $title = 'قسمت‌ / اپیزود';
    protected static ?string $modelLabel = 'قسمت‌ / اپیزود';
    protected static ?string $pluralLabel = 'قسمت‌ها / اپیزودها';
    protected static ?string $icon = 'zondicon-film';
    protected static bool $isLazy = false;
    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان'),
                Forms\Components\TextInput::make('title_en')
                    ->label('عنوان (انگلیسی)'),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->label('توضیحات'),

                Forms\Components\Textarea::make('description_en')
                    ->rows(3)
                    ->label('توضیحات (انگلیسی)'),


                Forms\Components\TextInput::make('season')
                    ->label('فصل')
                    ->required()
                    ->numeric()
                    ->visible(fn() => in_array($this->getOwnerRecord()->type , [EntityType::MultiSeasonSeries , EntityType::Series]))
                    ->minValue(0),

                Forms\Components\TextInput::make('episode')
                    ->label('قسمت')
                    ->required()
                    ->visible(fn() => in_array($this->getOwnerRecord()->type , [EntityType::MultiSeasonSeries , EntityType::Series]))
                    ->numeric()
                    ->minValue(0),



                Forms\Components\TextInput::make('imdb_rate')
                    ->label('امتیاز IMDb')
                    ->numeric()
                    ->ltr()
                    ->minValue(0)
                    ->maxValue(10)
                    ->step(0.1),



                Forms\Components\DatePicker::make('publish_date')
                    ->displayFormat('l d F Y')
                    ->jalali()
                    ->label('تاریخ انتشار'),

                Forms\Components\TextInput::make('pro_year')
                    ->label('سال تولید')
                    ->numeric()
                    ->ltr()
                    ->minValue(1300)
                    ->maxValue(now()->year + 1),


                Forms\Components\Select::make('age_range_id')
                    ->label('رده سنی')
                    ->relationship('ageRange' ,'title'),

                Forms\Components\Select::make('main_audio')
                    ->label('زبان محاوره')
                    ->searchable()
                    ->options(Audio::class)
                    ->native(false),


                Forms\Components\Toggle::make('is_high_definition')
                    ->label('محتوای بزرگسالان (18+)'),

                Forms\Components\Toggle::make('dubbed')
                    ->label('دوبله'),

                Forms\Components\Toggle::make('is_multi_audio')
                    ->label('چند زبانه'),

                Forms\Components\Toggle::make('has_subtitle')
                    ->label('زیرنویس'),

                Forms\Components\Toggle::make('exclusive')
                    ->label('اختصاصی'),

                Forms\Components\Repeater::make('crew')
                    ->label('تیم فنی')
                    ->relationship('crew')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Select::make('crew_id')
                            ->label('شخص')
                            ->relationship(name: 'crew', titleAttribute: 'name')
                            ->searchable(['name', 'name_en'])
                            ->required(),
                        Forms\Components\Select::make('position_id')
                            ->label('موقعیت')
                            ->relationship(name: 'position', titleAttribute: 'title')
                            ->searchable(['title'])
                            ->required(),
                    ])
                    ->columns(2)

            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('عنوان'),

                Tables\Columns\TextColumn::make('title_en')
                    ->searchable()
                    ->label('عنوان (انگلیسی)'),

                Tables\Columns\TextColumn::make('season')
                    ->label('فصل'),

                Tables\Columns\TextColumn::make('episode')
                    ->label('قسمت'),

                Tables\Columns\IconColumn::make('exclusive')
                    ->label('اختصاصی')
                    ->boolean(),

                Tables\Columns\TextColumn::make('publish_date')
                    ->label('تاریخ انتشار')
                    ->jalaliDate(),
            ])
            ->recordTitle(fn(Movie $record) => $record->entity->type == EntityType::Movie ? '' : (
                'قسمت : ' . $record->episode .
                ( $record->entity->type == EntityType::MultiSeasonSeries ? ' - فصل : '. $record->season : '' ) .
                ( $record->title ? ' - '. $record->title : '' )
            ) )
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('exclusive')->label('اختصاصی'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn() => in_array($this->getOwnerRecord()->type , [EntityType::MultiSeasonSeries , EntityType::Series]) or $this->getOwnerRecord()->movies()->count() == 0 )
                    ->label('افزودن قسمت'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('نمایش'),
                Tables\Actions\EditAction::make()->label('ویرایش'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
                Tables\Actions\RestoreAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
}
