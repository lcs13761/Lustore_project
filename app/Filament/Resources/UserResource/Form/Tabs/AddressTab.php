<?php

namespace App\Filament\Resources\UserResource\Form\Tabs;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class AddressTab
{
    public static function make():array
    {
        return [
            Repeater::make('addresses')
                ->relationship('addresses')
                ->schema([
                TextInput::make('cep'),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('district'),
                TextInput::make('street'),
                TextInput::make('number'),
                TextInput::make('complement'),
            ])->defaultItems(1)->columns()
        ];
    }
}
