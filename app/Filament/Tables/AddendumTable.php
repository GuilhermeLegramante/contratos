<?php

namespace App\Filament\Tables;

use App\Filament\Tables\Columns\FileLink;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class AddendumTable
{

    public static function table(): array
    {
        return [
            TextColumn::make('contract.number')
                ->label('Contrato')
                ->sortable(),
            TextColumn::make('number')
                ->label('Número')
                ->searchable(),
            TextColumn::make('start_date')
                ->label('Data de Início')
                ->date()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('end_date')
                ->label('Data de Término')
                ->date()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('global_value')
                ->label('Valor Global')
                ->money('BRL')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('monthly_value')
                ->label('Valor Mensal')
                ->money('BRL')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            FileLink::make('file')
                ->label('Arquivo')
                ->toggleable(isToggledHiddenByDefault: false)
                ->searchable(),
            IconColumn::make('is_active')
                ->label('Ativo')
                ->toggleable(isToggledHiddenByDefault: false)
                ->boolean(),
            TextColumn::make('adjustmentIndex.name')
                ->label('Índice de Reajuste')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),
            TextColumn::make('adjustment_percentual')
                ->label('Percentual de Reajuste')
                ->numeric()
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
