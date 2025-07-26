<?php

namespace App\Filament\Pages;

use App\Enums\RatioType;
use App\Models\Movie\Filepond;
use App\Models\Movie\Movie;
use App\Models\User\Admin;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Uploader extends Page implements HasForms, HasTable
{
    use InteractsWithTable , InteractsWithForms , HasPageShield;
    protected static ?string $navigationIcon = 'carbon-cloud-upload';

    protected static string $view = 'filament.pages.uploader';


    protected static ?string $navigationLabel = 'آپلودر ویدیو';
    protected static ?string $navigationGroup = 'مدیریت محتوا';
    protected static ?string $title = 'آپلودر ویدیو';

    public function table(Table $table): Table
    {
        return $table
            ->query(Filepond::query()->whereNotNull('filename')->where('is_used',false))
            ->modelLabel('آپلود')
            ->pluralModelLabel('آپلود ها')
            ->poll('5s')
            ->columns([
                TextColumn::make('filename')
                    ->searchable()
                    ->label('عنوان فایل'),
                TextColumn::make('creator.name')
                    ->formatStateUsing(fn($record) => Admin::query()->find($record->created_by)->name)
                    ->label('آپلود شده توسط'),
                TextColumn::make('expires_at')
                    ->formatStateUsing(fn($record) => $record->expires_at->diffForHumans())
                    ->label('مقضی در'),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn($record) => $record->created_at->diffForHumans())
                    ->label('شروع آپلود در'),
//                TextColumn::make('filepath'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make('trash')
            ])
            ->actions([
                ForceDeleteAction::make('forceDelete'),
                DeleteAction::make('forceDelete'),
                RestoreAction::make('forceDelete'),
                Tables\Actions\Action::make('setToMovie')
                    ->label('اختصاص به فیلم')
                    ->icon('carbon-video-add')
                    ->form([
                        Select::make('movieID')
                            ->label('فیلم')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Movie::query()->where('title', 'like', "%{$search}%")->orWhereHas('entity' , fn($builder) => $builder->where('title' ,'like', "%{$search}%" ))->limit(50)->pluck('title', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => Movie::query()->whereIn('id', $values)->pluck('title', 'id')->toArray())
                            ->required(),
                        Select::make('ratio_type')
                            ->label('نوع نسبت تصویر')
                            ->required()
                            ->options(RatioType::class)
                            ->native(false),
                    ])
                    ->action(function (array $data, Filepond $record): void {
                        if ( !  $record->is_used ) {
                            /** @var Movie $movie */
                            $movie = Movie::query()->findOrFail($data['movieID']);
                            $ratio = RatioType::from($data['ratio_type']);
                            Storage::makeDirectory('private/movies/');
                            Storage::makeDirectory('private/movies/' . str($movie->id)->substr(0, 2));
                            Storage::makeDirectory('private/movies/' . str($movie->id)->substr(0, 2) . '/' . str($movie->id)->substr(0, 5));
                            Storage::makeDirectory('private/movies/' . str($movie->id)->substr(0, 2) . '/' . str($movie->id)->substr(0, 5) . '/' . $movie->id);
                            Storage::makeDirectory('private/movies/' . str($movie->id)->substr(0, 2) . '/' . str($movie->id)->substr(0, 5) . '/' . $movie->id . '/' . $ratio->name);
                            File::move(storage_path('app/'.$record->filepath), storage_path('app/private/movies/' . str($movie->id)->substr(0, 2) . '/' . str($movie->id)->substr(0, 5) . '/' . $movie->id . '/' . $ratio->name.'/'.$record->filename));
                            $record->is_used = true;
                            $record->save();
                            $movie->files()->create([
                                'movie_id' => $movie->id,
                                'ratio_type' => $ratio->value,
                                'path' => 'private/movies/' . str($movie->id)->substr(0, 2) . '/' . str($movie->id)->substr(0, 5) . '/' . $movie->id . '/' . $ratio->name.'/'.$record->filename
                            ]);
                            Notification::make()
                                ->title('فیلم با موفقت اختصاص یافت.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('این فایل به یک فیلم اختصاص داده شده است!')
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
}
