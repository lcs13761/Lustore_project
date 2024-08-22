<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-m-numbered-list';

    protected static ?int $navigationSort = 2;

    /**
     * Retrieves the navigation group for the User resource.
     *
     * @return string|null The localized navigation group for the User resource, or null if not set.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('Products');
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\Select::make('parent_id')->relationship('parent', 'name'),

                        Forms\Components\TextInput::make('name')->required()->maxLength(255),

                        Forms\Components\Textarea::make('description')->columnSpanFull(),
                    ]),
                    Forms\Components\Section::make([
                        Forms\Components\DateTimePicker::make('created_at')->disabled(),

                        Forms\Components\DateTimePicker::make('updated_at')->disabled(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->directory('category')
                            ->collection('category'),

                        Forms\Components\Toggle::make('is_active')
                    ])->grow(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('parent.name')
//                    ->numeric()
//                    ->sortable(),

                Tables\Columns\TextColumn::make('name')->searchable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->badge()
                    ->label(__('Products'))
                    ->counts('products')
                    ->colors(['success']),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
