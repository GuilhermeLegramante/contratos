<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\TextColumn;

class ContactTable
{

    public static function table(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable(),
            TextColumn::make('email')
                ->label('E-mail')
                ->searchable(),
            TextColumn::make('whatsapp')
                ->label('Whatsapp')
                ->searchable(),
            TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Editado em')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
