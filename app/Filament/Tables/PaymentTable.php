<?php

namespace App\Filament\Tables;

use App\Filament\Tables\Columns\FileLink;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class PaymentTable
{

    public static function table(): array
    {
        return [
            TextColumn::make('contract.number')
                ->label('Contrato')
                ->sortable(),
            TextColumn::make('date')
                ->label('Data')
                ->date()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('value')
                ->label('Valor')
                ->money('BRL')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('paymentMethod.name')
                ->label('Forma de Pagamento')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
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
