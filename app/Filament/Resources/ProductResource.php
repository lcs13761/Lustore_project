<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;
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
        return __('Product');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->prefix('R$')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('size')
                            ->required(),
                        Forms\Components\TextInput::make('color')
                            ->required(),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->required(),
                        Forms\Components\TextInput::make('sku')
                            ->required(),
                        Forms\Components\TextInput::make('barcode')
                            ->required(),
                        Forms\Components\TextInput::make('material')
                            ->required(),
                        Forms\Components\TextInput::make('gender')
                            ->required(),
                        Forms\Components\TextInput::make('weight')
                            ->required(),
                        Forms\Components\TextInput::make('dimensions')
                            ->required(),

                        Forms\Components\Textarea::make('description')->columnSpanFull(),
                    ])->columns(),

                    Forms\Components\Section::make([

                        Forms\Components\DateTimePicker::make('created_at')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('updated_at')
                            ->disabled(),

                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('brand')
                            ->relationship('brand', 'name')
                            ->preload()
                            ->required(),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->collection('products'),

                        Forms\Components\Toggle::make('is_active'),

                    ])->grow(false),
                ]),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->badge(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\BooleanColumn::make('active')
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->hidden(),
            ])
            ->filters([
//                Tables\Filters\TrashedFilter::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
