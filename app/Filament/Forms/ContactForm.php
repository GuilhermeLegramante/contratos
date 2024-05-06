<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ContactForm
{

    public static function form(): array
    {
        return [
            TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->maxLength(255),
            PhoneNumber::make('whatsapp')
                ->label('Whatsapp'),
            Textarea::make('note')
                ->label('Observação')
                ->maxLength(65535)
                ->columnSpanFull(),
        ];
    }
}
