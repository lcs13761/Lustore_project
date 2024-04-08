<?php

namespace App\Filament\Resources\UserResource\Form\Tabs;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class MainTab
{
    public static function make(): array
    {
        return [
           TextInput::make('name')
                ->required()
               ->label(__('locale.labels.name'))
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->label(__('locale.labels.email'))
                ->required()
                ->maxLength(255),

            TextInput::make('cpf')
                ->label(__('locale.labels.cpf'))
                ->maxLength(255),

            TextInput::make('phone')
                ->tel()
                ->label(__('locale.labels.phone'))
                ->maxLength(255),

            //password
            TextInput::make('password')
                ->password()
                ->required(fn ($context): bool => $context === 'create')
                ->confirmed()
                ->minLength(8)
                ->label(__('locale.labels.password'))
                ->placeholder(__('locale.labels.password'))
                ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                ->dehydrated(fn ($state): bool => filled($state))
                ->visibleOn(['create', 'edit']),

            //password confirmation
            TextInput::make('password_confirmation')
                ->password()
                ->label(__('locale.labels.password_confirmation'))
                ->placeholder(__('locale.labels.password_confirmation'))
                ->required(fn ($context): bool => $context === 'create')
                ->dehydrated(false)
                ->visibleOn(['create', 'edit']),

            Forms\Components\Toggle::make('active')
                ->label(__('locale.labels.active'))
                ->required(),
        ];
    }
}
