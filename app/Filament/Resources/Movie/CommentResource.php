<?php

namespace App\Filament\Resources\Movie;

use App\Enums\PublishStatus;
use App\Filament\Resources\Movie\EntityResource\Pages\ViewEntity;
use App\Filament\Resources\Movie\CommentResource\Pages;
use App\Filament\Resources\User\UserResource\Pages\ViewUser;
use App\Models\Movie\Comment;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Comment::class;

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationGroup = 'مدیریت محتوا';
    protected static ?string $label = 'نظر بینندگان';
    protected static ?string $pluralLabel = 'نظرات بینندگان';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';


    public static function getNavigationBadge(): ?string
    {
        return Comment::query()->where('publish_status' , PublishStatus::Pending->value)->count();
    }

//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery()->when(request()->query('for_house_id' , false) , function (Builder $builder){
//            $house = House::query()->findOrFail(request()->query('for_house_id' , false));
//            /** @var Comment $builder */
//            $builder->ForHouse($house);
//        })->when(request()->query('for_reserve_id' , false) , function (Builder $builder){
//            $builder->where('reserve_id' ,request()->query('for_reserve_id' , false) );
//        });
//    }
    public static function form(Form $form): Form
    {
        return $form;
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(2)
            ->schema([
                TextEntry::make('movie.title')
                    ->inlineLabel()
                    ->label('فیلم:')
                    ->icon('heroicon-s-link')
                    ->url(fn (Comment $record) => ViewEntity::getUrl(['record' => $record->movie->entity_id]))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn (Comment $record) => $record->movie->title ),
                TextEntry::make('profile.user_id')
                    ->inlineLabel()
                    ->label('بیننده:')
                    ->icon('heroicon-s-link')
                    ->url(fn (Comment $record) => ViewUser::getUrl(['record' => $record->profile->user_id]))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn (Comment $record) => $record->profile->user->name ),

//                TextEntry::make('controller_id')
//                    ->inlineLabel()
//                    ->visible(fn (Comment $record) => $record->controller)
//                    ->label('ناظر:')
//                    ->icon('heroicon-s-link')
//                    ->url(fn (Comment $record) => ViewUser::getUrl(['record' => $record->controller_id]))
//                    ->openUrlInNewTab()
//                    ->formatStateUsing(fn (Comment $record) => $record->controller->name ),
                TextEntry::make('created_at')
                    ->inlineLabel()
                    ->formatStateUsing(fn (Comment $record) => $record->created_at->toJalali()->format('d F Y,  H:i:s'))
                    ->label('زمان ایجاد:'),
                TextEntry::make('comment')
                    ->html()
                    ->columnSpanFull()
                    ->formatStateUsing(fn (Comment $record) => nl2br($record->comment))
                    ->label('نظر:'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('movie.title')
                    ->label('فیلم'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publish_status')
                    ->label('وضعیت')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('publish_status')
                    ->label('وضعیت')
                    ->options(PublishStatus::class),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make('view')
                    ->extraModalFooterActions([
                        Tables\Actions\Action::make('approve_document')
                            ->icon('iconic-check')
                            ->hidden(! filament()->auth()->user()->can('update_comment'))
                            ->visible(fn (Comment $record) => in_array($record->publish_status,[PublishStatus::Pending,PublishStatus::Reject]))
                            ->label('تایید')
                            ->color('success')
                            ->action(function($record){
                                /** @var Document $record */
                                $record->update([
                                    'publish_status' => PublishStatus::Publish,
                                    'controller_id' => filament()->auth()->user()->id
                                ]);
                            }),
                        Tables\Actions\Action::make('reject_document')
                            ->icon('maki-cross')
                            ->hidden(! filament()->auth()->user()->can('update_comment'))
                            ->visible(fn (Comment $record) => in_array($record->publish_status,[PublishStatus::Pending,PublishStatus::Publish]))
                            ->label('رد نظر')
                            ->color('danger')
                            ->action(function($record){
                                /** @var Comment $record */
                                $record->update([
                                    'publish_status' => PublishStatus::Reject,
                                    'controller_id' => filament()->auth()->user()->id,
                                ]);
                            }),
                        Tables\Actions\DeleteAction::make()
                            ->visible(fn (Comment $record) => $record->publish_status == PublishStatus::Reject),
                    ])
                    ->slideOver(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'update',
            'delete',
        ];
    }
}
