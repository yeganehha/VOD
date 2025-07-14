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
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Guava\FilamentClusters\Forms\Cluster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\BooleanEntry;
use Filament\Infolists\Components\IconEntry;

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
                    ->native(false)
                    ->relationship('ageRange' ,'title'),
                Forms\Components\Select::make('main_audio')
                    ->label('زبان محاوره')
                    ->searchable()
                    ->native(false)
                    ->options(Audio::class),
                Cluster::make([
                    Forms\Components\Select::make('weekly_release_schedule_day')
                        ->prefix('در روز')
                        ->native(false)
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
                Grid::make(4)->schema([
                    TextEntry::make('title')->label('عنوان'),
                    TextEntry::make('title_en')->label('عنوان (انگلیسی)'),
                    TextEntry::make('second_title')->label('عنوان دوم'),
                    TextEntry::make('second_title_en')->label('عنوان دوم (انگلیسی)'),
                    TextEntry::make('pre_title')->label('پیشوند عنوان'),
                    TextEntry::make('pre_title_en')->label('پیشوند عنوان (انگلیسی)'),
                    TextEntry::make('slug')->label('نامک'),
                    TextEntry::make('type')
                        ->label('نوع محتوا')
                        ->formatStateUsing(fn ($state) => match($state) {
                            'Movie' => 'فیلم',
                            'Series' => 'سریال',
                            'MultiSeasonSeries' => 'چندفصلی',
                            default => $state,
                        }),
                    TextEntry::make('publish_status')
                        ->label('وضعیت انتشار')
                        ->formatStateUsing(fn ($state) => match($state) {
                            'Published' => 'منتشر شده',
                            'Draft' => 'پیش‌نویس',
                            'Pending' => 'در انتظار',
                            default => $state,
                        }),
                    TextEntry::make('weekly_release_schedule_day')
                        ->label('روز پخش هفتگی')
                        ->formatStateUsing(fn ($state) => match($state) {
                            'Saturday' => 'شنبه',
                            'Sunday' => 'یک‌شنبه',
                            'Monday' => 'دوشنبه',
                            'Tuesday' => 'سه‌شنبه',
                            'Wednesday' => 'چهارشنبه',
                            'Thursday' => 'پنج‌شنبه',
                            'Friday' => 'جمعه',
                            default => $state,
                        }),
                    TextEntry::make('weekly_release_schedule_hour')
                        ->label('ساعت پخش')
                        ->dateTime('H:i'),
                    TextEntry::make('pro_year')->label('سال تولید'),
                    TextEntry::make('main_audio')
                        ->label('زبان')
                        ->formatStateUsing(fn($state) => $state?->getLabel() ?? '-'),
                    TextEntry::make('ageRange.title')->label('رده سنی'),
                    IconEntry::make('exclusive')
                        ->label('اختصاصی')
                        ->boolean(),

                    IconEntry::make('is_free_movie')
                        ->label('رایگان')
                        ->boolean(),
                ]),

                Grid::make(4)->schema([
                    TextEntry::make('genres')
                        ->label('ژانرها')
                        ->formatStateUsing(fn(Entity $entity) => $entity->genres?->pluck('title')->join(', ') ?? '-'),

                    TextEntry::make('countries')
                        ->label('کشورها')
                        ->formatStateUsing(fn(Entity $entity) => $entity->countries?->pluck('name')->join(', ') ?? '-'),
                    TextEntry::make('created_at')->label('تاریخ ایجاد')->date('Y/m/d - H:i'),
                    TextEntry::make('updated_at')->label('آخرین ویرایش')->date('Y/m/d - H:i'),
                ]),

                Group::make()->schema([
                    TextEntry::make('about_movie')->label('درباره فیلم')->markdown(),
                    TextEntry::make('about_movie_en')->label('درباره فیلم (انگلیسی)')->markdown(),
                ])->columnSpanFull()->columns(2),

                Grid::make(2)->schema([
                    ImageEntry::make('logo')->label('لوگوی مجموعه'),
                    ImageEntry::make('movie_logo')->label('لوگوی فیلم'),
                ])->columnSpanFull(),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title_en')
                    ->label('عنوان (انگلیسی)')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('نوع محتوا')
                    ->sortable(),

                TextColumn::make('genres.title')
                    ->label('ژانرها')
                    ->badge()
                    ->separator(', '),

                TextColumn::make('publish_status')
                    ->label('وضعیت انتشار')
                    ->sortable(),


                TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->jalaliDateTime('d F Y,  H:i:s')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('type')
                    ->label('نوع محتوا')
                    ->options([
                        EntityType::Movie->value => 'فیلم',
                        EntityType::Series->value => 'سریال',
                        EntityType::MultiSeasonSeries->value => 'چندفصلی',
                    ]),

                SelectFilter::make('publish_status')
                    ->label('وضعیت انتشار')
                    ->options(PublishStatus::class),

                TernaryFilter::make('exclusive')
                    ->label('اختصاصی'),

                TernaryFilter::make('is_free_movie')
                    ->label('رایگان'),

                MultiSelectFilter::make('genres')
                    ->label('ژانرها')
                    ->relationship('genres', 'title'),

                MultiSelectFilter::make('countries')
                    ->label('کشورها')
                    ->relationship('countries', 'name'),
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
            RelationManagers\MoviesRelationManager::class,
            RelationManagers\CoversRelationManager::class,
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
