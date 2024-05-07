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

class PaymentForm
{
    public static function form(): array
    {
        return [
            Select::make('payment_method_id')
                ->label('Forma de Pagamento')
                ->relationship('paymentMethod', 'name')
                ->searchable()
                ->preload()
                ->columnSpanFull()
                ->createOptionForm(PaymentMethodForm::form())
                ->required(),
            DatePicker::make('date')
                ->required()
                ->label('Data'),
            Money::make('value')
                ->required()
                ->label('Valor'),
            Textarea::make('note')
                ->label('Observação')
                ->maxLength(65535)
                ->columnSpanFull(),
        ];
    }
}
