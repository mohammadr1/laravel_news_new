<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\NewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsResource\RelationManagers;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('title')
                ->label('عنوان')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->label('نامک')
                ->unique(ignoreRecord: true)
                ->required(),

            TextInput::make('subtitle')
                ->label('زیرعنوان')
                ->maxLength(255),

            Textarea::make('meta_description')
                ->label('توضیحات متا')
                ->rows(2),

            RichEditor::make('body')
                ->label('محتوا')
                ->required()
                ->columnSpan('full'), // این خط باعث می‌شه تمام عرض فرم رو بگیره

            FileUpload::make('image')
                ->label('تصویر شاخص')
                ->image()
                ->directory('thumbnails'),

            // Select::make('category_id')
            //     ->label('دسته‌بندی')
            //     ->relationship('category', 'name')
            //     ->searchable()
            //     ->required(),

            // Select::make('author_id')
            //     ->label('نویسنده')
            //     ->relationship('author', 'name')
            //     ->required(),

            TagsInput::make('tags')
                ->label('برچسب‌ها'),

            DateTimePicker::make('published_at')
                ->label('تاریخ انتشار')
                ->jalali()
                ->required(),

            // Toggle::make('is_featured')
            //     ->label('ویژه باشد؟'),


                Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        0 => 'پیش‌نویس',
                        1 => 'منتشر شده',
                        2 => 'آرشیو شده',
                    ])
                    ->default(0)
                    ->required(),

                    Select::make('position')
                    ->label('موقعیت قرارگیری خبر در سایت')
                    ->options([
                        'slider_bottom' => 'پایین اسلایدر',
                        'slider_side' => 'سمت چپ اسلایدر',
                    ])
                    ->default('slider_bottom'),


                Hidden::make('author_id')
                    ->default(fn () => auth()->id())
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('image')
                ->label('تصویر شاخص')
                ->square()
                ->disk('public') // اگر از disk public استفاده می‌کنی
                ->url(fn ($record) => asset('storage/thumbnails/' . $record->thumbnail)), // مسیر دستی


            TextColumn::make('title')
                ->label('عنوان')
                ->searchable()
                ->sortable(),

            // TextColumn::make('category.name')
            //     ->label('دسته‌بندی'),

            BadgeColumn::make('status')
                ->label('وضعیت')
                ->colors([
                    'پیش‌نویس' => 'gray',
                    'منتشر شده' => 'green',
                    'آرشیو شده' => 'red',
                ])
                ->formatStateUsing(function ($state) {
                    return match ($state) {
                        0 => 'پیش‌نویس',
                        1 => 'منتشر شده',
                        2 => 'آرشیو شده',
                        default => 'نامشخص',
                    };
                }),
            // ToggleColumn::make('is_featured')
            //     ->label('ویژه؟'),

            TextColumn::make('published_at')
                ->label('تاریخ انتشار')
                ->dateTime()
                ->date() // ✅ نمایش به‌صورت تاریخ
                ->when(App::isLocale('fa'), fn (TextColumn $column) => $column->jalaliDate()),
        ])
        ->defaultSort('published_at', 'desc')
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
