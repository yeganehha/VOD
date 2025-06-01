<?php

namespace App\Filament\Resources\Movie;

use App\Enums\Gender;
use App\Filament\Resources\Movie\CrewResource\Pages;
use App\Models\Movie\Crew;
use App\Models\Movie\CrewPosition;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static ?string $navigationGroup = 'مدیریت محتوا';

    protected static ?string $label = 'عضو';
    protected static ?string $pluralLabel = 'اعضای تیم سازنده';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('نام شخص'),
                Forms\Components\TextInput::make('name_en')
                    ->required()
                    ->maxLength(255)
                    ->label('نام شخص (انگلیسی)'),
                TinyEditor::make('biography')
                    ->label('بیوگرافی'),
                TinyEditor::make('biography_en')
                    ->label('بیوگرافی (انگلیسی)'),
                DatePicker::make('birthday')
                    ->label('تاریخ تولد')
                    ->displayFormat('l d F Y')
                    ->jalali()
//                    ->timezone('Asia/Tehran')
                    ->closeOnDateSelection()
                    ->maxDate(now()->subYear()->startOfYear()),
                DatePicker::make('death_at')
                    ->label('تاریخ فوت')
                    ->displayFormat('l d F Y')
                    ->jalali()
//                    ->timezone('Asia/Tehran')
                    ->closeOnDateSelection()
                    ->maxDate(now()->addDay()->startOfDay()),
                Forms\Components\Select::make('birth_location_id')
                    ->label('متولد کشور')
                    ->preload()
                    ->searchable()
                    ->relationship('birthLocation', 'title'),
                Forms\Components\ToggleButtons::make('gender')
                    ->required()
                    ->label('جنسیت')
                    ->inline()
                    ->options(Gender::class),
                Forms\Components\Select::make('main_position_id')
                    ->label('وظیفه اصلی در تیم تولید')
                    ->preload()
                    ->searchable()
                    ->relationship('mainPosition', 'title'),
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
                                        CrewPosition::query()->find($get('main_position_id'))?->slug ?? '',
                                        Gender::from($get('gender') ?? Gender::Male->value)->getSlug(),
                                        $get('name_en')
                                    ])
                                ) );
                            })
                    )
                    ->rules(['alpha_dash:ascii'])
                    ->unique('crew_positions' ,'slug' , ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('فقط حروف انگلیسی و عدد و (-,_)')
                    ->label('نامک'),
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->imageEditor()
                    ->directory('crew_avatar/'.now()->format('Y/m/d'))
                    ->label('آواتار'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام شخص')
                    ->searchable(),
                TextColumn::make('name_en')
                    ->label('نام شخص (انگلیسی)')
                    ->searchable(),
                TextColumn::make('mainPosition.title')
                    ->label('همکاری در'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCrews::route('/'),
            'create' => Pages\CreateCrew::route('/create'),
            'view' => Pages\ViewCrew::route('/{record}'),
            'edit' => Pages\EditCrew::route('/{record}/edit'),
        ];
    }
}
