<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class AddendumForm
{
    public static function form(): array
    {
        return [
            TextInput::make('number')
                ->label('Número')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),
            Select::make('adjustment_index_id')
                ->label('Índice de Reajuste')
                ->relationship('adjustmentIndex', 'name')
                ->required(),
            TextInput::make('adjustment_percentual')
                ->label('Percentual de Reajuste')
                ->required()
                ->numeric()
                ->suffix('%'),
            DatePicker::make('start_date')
                ->label('Data de Início'),
            DatePicker::make('end_date')
                ->label('Data de Término'),
            TextInput::make('global_value')
                ->numeric()
                ->label('Valor Global'),
            TextInput::make('monthly_value')
                ->numeric()
                ->label('Valor Mensal'),
            FileUpload::make('file')
                ->label('Arquivo'),
            Toggle::make('is_active')
                ->inline(false)
                ->label('Ativo'),
            Textarea::make('note')
                ->label('Observação')
                ->maxLength(65535)
                ->columnSpanFull(),
        ];
    }
}
