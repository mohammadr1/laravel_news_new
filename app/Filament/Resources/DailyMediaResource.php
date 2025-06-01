<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyMediaResource\Pages;
use App\Filament\Resources\DailyMediaResource\RelationManagers;
use App\Models\DailyMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload, Select, Toggle, DateTimePicker};
use Filament\Tables\Columns\{TextColumn, IconColumn, ImageColumn, ToggleColumn};
use Illuminate\Support\Facades\App;

class DailyMediaResource extends Resource
{
    protected static ?string $model = DailyMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'مدیریت محتوای تصاویر / ویدیو';
    protected static ?string $modelLabel = 'ویدیو / تصویر شاخص روز';         // عنوان مفرد
    protected static ?string $pluralLabel = 'ویدیو / تصویر شاخص روز';          // جمع
    protected static ?string $navigationLabel = 'ویدیو / تصویر شاخص روز';      // عنوان در سایدبار

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->label('عنوان'),
                Textarea::make('lead')->label('لید')->rows(3),

                Select::make('media_type')
                    ->options([
                        'image' => 'تصویر',
                        'video' => 'ویدیو',
                    ])
                    ->required()
                    ->live(), // برای ری‌اکتیو بودن تغییرات

                Toggle::make('is_external')->label('ویدیو از لینک خارجی است؟')
                    ->visible(fn (Forms\Get $get) => $get('media_type') === 'video')
                    ->live(),

                TextInput::make('media_path')
                    ->label('لینک ویدیو (آپارات / یوتیوب)')
                    ->visible(fn (Forms\Get $get) => $get('media_type') === 'video' && $get('is_external'))
                    ->required(fn (Forms\Get $get) => $get('media_type') === 'video' && $get('is_external')),

                FileUpload::make('media_path')
                    ->label('آپلود تصویر یا ویدیو')
                    ->disk('public')
                    ->directory('daily-media')
                    ->visible(fn (Forms\Get $get) => !$get('is_external'))
                    ->required(fn (Forms\Get $get) => !$get('is_external')),

                Toggle::make('status')
                    ->label('فعال')
                    ->default(true),

                DateTimePicker::make('published_at')
                ->label('تاریخ انتشار')
                ->jalali(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('media_type')->label('نوع'),
                TextColumn::make('published_at')->label('انتشار')->dateTime()
                ->date() // ✅ نمایش به‌صورت تاریخ
                ->when(App::isLocale('fa'), fn (TextColumn $column) => $column->jalaliDate()),
                ToggleColumn::make('status')->label('وضعیت'),
            ])->defaultSort('published_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDailyMedia::route('/'),
            'create' => Pages\CreateDailyMedia::route('/create'),
            'edit' => Pages\EditDailyMedia::route('/{record}/edit'),
        ];
    }
}
