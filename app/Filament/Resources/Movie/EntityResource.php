<?php

namespace App\Filament\Resources\Movie;

use App\Enums\Audio;
use App\Enums\EntityType;
use App\Enums\Gender;
use App\Enums\PublishStatus;
use App\Enums\WeekDay;
use App\Filament\Resources\Movie\EntityResource\Pages;
use App\Filament\Resources\Movie\EntityResource\RelationManagers;
use App\Models\Movie\CrewPosition;
use App\Models\Movie\Entity;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentClusters\Forms\Cluster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class EntityResource extends Resource
{
    protected static ?string $model = Entity::class;
    protected static ?string $navigationGroup = 'مدیریت محتوا';

    protected static ?string $label = 'فیلم و سریال';
    protected static ?string $pluralLabel = 'فیلم‌ها و سریال‌ها';

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان'),
                Forms\Components\TextInput::make('title_en')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان (انگلیسی)'),
                Forms\Components\TextInput::make('second_title')
                    ->maxLength(255)
                    ->label('عنوان دوم'),
                Forms\Components\TextInput::make('second_title_en')
                    ->maxLength(255)
                    ->label('عنوان دوم (انگلیسی)'),
                Forms\Components\TextInput::make('pre_title')
                    ->maxLength(255)
                    ->label('پیشوند عنوان'),
                Forms\Components\TextInput::make('pre_title_en')
                    ->maxLength(255)
                    ->label('پیشوند عنوان (انگلیسی)'),
                Forms\Components\ToggleButtons::make('type')
                    ->required()
                    ->label('نوع')
                    ->inline()
                    ->options(EntityType::class),
                Forms\Components\ToggleButtons::make('publish_status')
                    ->required()
                    ->label('وضعیت')
                    ->inline()
                    ->options(PublishStatus::class),
                Forms\Components\Select::make('age_range_id')
                    ->label('رده سنی')
                    ->relationship('ageRange' ,'title'),
                Forms\Components\Select::make('main_audio')
                    ->label('زبان محاوره')
                    ->searchable()
                    ->options(Audio::class),
                Cluster::make([
                    Forms\Components\Select::make('weekly_release_schedule_day')
                        ->prefix('در روز')
                        ->options(WeekDay::class),
                    Forms\Components\TimePicker::make('weekly_release_schedule_hour')
                        ->native(true)
                        ->seconds(false)
                        ->prefix('در ساعت'),
                ])->label('اکران هر هفته'),
                Forms\Components\TextInput::make('pro_year')
                    ->minValue(1200)
                    ->maxValue(now()->addYear()->year)
                    ->ltr()
                    ->label('سال انتشار'),
                Forms\Components\Toggle::make('exclusive')
                    ->label('انحصاری مجموعه')
                    ->inline(),
                Forms\Components\Toggle::make('is_free_movie')
                    ->label('بدون نیاز به خرید اشتراک')
                    ->inline(),
                TinyEditor::make('about_movie')
                    ->label('درباره فیلم'),
                TinyEditor::make('about_movie_en')
                    ->label('درباره فیلم (انگلیسی)'),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->imageEditor()
                    ->directory('entity/logo/'.now()->format('Y/m/d'))
                    ->label('لوگو'),
                Forms\Components\FileUpload::make('movie_logo')
                    ->image()
                    ->imageEditor()
                    ->directory('entity-movie/logo/'.now()->format('Y/m/d'))
                    ->label('لوگو فیلم'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->ltr()
                    ->suffixAction(
                        Action::make('addSlug')
                            ->icon('bi-stars')
                            ->tooltip('ساخت نامک')
                            ->action(function (Set $set, Forms\Get $get) {
                                $set('slug', Str::slug(
                                    implode(' ', [
                                        empty($get('pre_title_en')) ? (empty($get('pre_title')) ? '' : $get('pre_title')) : $get('pre_title_en'),
                                        empty($get('title_en')) ? $get('title') : $get('title_en'),
                                    ])
                                ) );
                            })
                    )
                    ->rules(['alpha_dash:ascii'])
                    ->unique('entities' ,'slug' , ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('فقط حروف انگلیسی و عدد و (-,_)')
                    ->label('نامک'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                //
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListEntities::route('/'),
            'create' => Pages\CreateEntity::route('/create'),
            'view' => Pages\ViewEntity::route('/{record}'),
            'edit' => Pages\EditEntity::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
