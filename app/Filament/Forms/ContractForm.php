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

class ContractForm
{

    public static function form(): array
    {
        return [
            Section::make('Dados do Contrato')
                ->description(
                    fn (string $operation): string => $operation === 'create' || $operation === 'edit' ? 'Informe os campos solicitados' : ''
                )
                ->schema([
                    Select::make('client_id')
                        ->label('Cliente')
                        ->relationship('client', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull()
                        ->createOptionForm(ClientForm::form()),
                    TextInput::make('number')
                        ->label('Número')
                        ->required()
                        ->maxLength(255),
                    Select::make('hiring_method_id')
                        ->label('Forma de Contratação')
                        ->relationship('hiringMethod', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->createOptionForm(HiringMethodForm::form()),
                    DatePicker::make('start_date')
                        ->label('Data de Início'),
                    DatePicker::make('end_date')
                        ->label('Data de Término'),
                    Money::make('global_value')
                        ->label('Valor Global'),
                    Money::make('monthly_value')
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
                ])->columns(2)
        ];
    }
}
