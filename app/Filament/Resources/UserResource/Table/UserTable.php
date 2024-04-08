<?php

namespace App\Filament\Resources\UserResource\Table;

use Filament\Tables\Table;
use Filament\Tables;

class UserTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('locale.labels.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('locale.labels.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label(__('locale.labels.cpf'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('locale.labels.phone'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label(__('locale.labels.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('locale.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('locale.labels.updated_at'))
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
}
