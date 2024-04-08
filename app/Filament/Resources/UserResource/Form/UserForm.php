<?php

namespace App\Filament\Resources\UserResource\Form;

use App\Filament\Resources\UserResource\Form\Tabs\AddressTab;
use App\Filament\Resources\UserResource\Form\Tabs\MainTab;
use Filament\Forms\Form;
use Filament\Forms;

class UserForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()->tabs([
                    Forms\Components\Tabs\Tab::make('main')->schema(MainTab::make())->columns(),
                    Forms\Components\Tabs\Tab::make('address')->schema(AddressTab::make())
                ])->columnSpan(['default' => 12])
            ]);
    }
}

