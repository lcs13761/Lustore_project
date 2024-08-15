<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    /**
     * Retrieves the navigation group for the User resource.
     *
     * @return string|null The localized navigation group for the User resource, or null if not set.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('Users');
    }

    /**
     * Retrieves the label for the User model.
     *
     * @return string The localized label for the User model.
     */
    public static function getModelLabel(): string
    {
        return __('User');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Tabs::make()->tabs([
                        Forms\Components\Tabs\Tab::make('main')
                            ->label(__('Main'))
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('cpf')
                                    ->maxLength(255),

                                TextInput::make('phone_number')
                                    ->tel()
                                    ->maxLength(255),

                                //password
                                TextInput::make('password')
                                    ->password()
                                    ->required(fn($context): bool => $context === 'create')
                                    ->confirmed()
                                    ->minLength(8)
                                    ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                                    ->dehydrated(fn($state): bool => filled($state))
                                    ->visibleOn(['create', 'edit']),

                                //password confirmation
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->required(fn($context): bool => $context === 'create')
                                    ->dehydrated(false)
                                    ->visibleOn(['create', 'edit']),


                            ])->columns(),

                        Forms\Components\Tabs\Tab::make('addresses')
                            ->label(__('Addresses'))
                            ->schema([
                                Repeater::make('addresses')
                                    ->relationship('addresses')
                                    ->schema([
                                        TextInput::make('postcode')
                                            ->columnSpan(['default' => 6, 'sm' => 1])
                                            ->placeholder('00000-000')
                                            ->extraAlpineAttributes(['x-mask' => '99999-999'])
                                            ->reactive()
                                            ->lazy(),

                                        TextInput::make('city')
                                            ->columnSpan(['default' => 6, 'sm' => 2]),
                                        Forms\Components\Select::make('state')
                                            ->relationship('state', 'name')
                                            ->preload()
                                            ->columnSpan(['default' => 6, 'sm' => 2]),
                                        TextInput::make('number')
                                            ->numeric()
                                            ->columnSpan(['default' => 6, 'sm' => 1]),
                                        TextInput::make('district')
                                            ->columnSpan(['default' => 6, 'sm' => 2]),
                                        TextInput::make('street')
                                            ->columnSpan(['default' => 6, 'sm' => 2]),
                                        TextInput::make('complement')
                                            ->columnSpan(['default' => 6, 'sm' => 2]),
                                    ])->defaultItems(1)->columns(6)
                            ])->columnSpan(['default' => 12])
                    ]),

                    Forms\Components\Section::make([

                        Forms\Components\DateTimePicker::make('created_at')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('updated_at')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->disabled(),

                        Forms\Components\Select::make('role')
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => Str::ucfirst($record->name))
                            ->preload(),

                        Forms\Components\Toggle::make('is_active')->required(),

                    ])->grow(false),
                ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('cpf')->searchable(),

                Tables\Columns\TextColumn::make('phone_number')->searchable(),

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
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
