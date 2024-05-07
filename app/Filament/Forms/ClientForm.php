<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ClientForm
{

    public static function form(): array
    {
        return [
            Section::make('Dados do Cliente')
                ->description(
                    fn (string $operation): string => $operation === 'create' || $operation === 'edit' ? 'Informe os campos solicitados' : ''
                )
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),
                    Document::make('cpf_cnpj')
                        ->label('CPF ou CNPJ')
                        ->required()
                        ->validation(false)
                        ->dynamic(),
                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->maxLength(255),
                    PhoneNumber::make('phone')
                        ->label('Telefone'),
                    Fieldset::make('Endereço')
                        ->relationship('address')
                        ->schema([
                            Cep::make('postal_code')
                                ->label(__('fields.cep'))
                                ->live(onBlur: true)
                                ->viaCep(
                                    mode: 'suffix',
                                    errorMessage: 'CEP inválido.',
                                    setFields: [
                                        'street' => 'logradouro',
                                        'number' => 'numero',
                                        'complement' => 'complemento',
                                        'district' => 'bairro',
                                        'city' => 'localidade',
                                        'state' => 'uf',
                                    ]
                                ),
                            TextInput::make('street')->label(__('fields.street'))->columnSpan(1),
                            TextInput::make('number')->label(__('fields.number')),
                            TextInput::make('complement')->label(__('fields.complement')),
                            TextInput::make('reference')->label(__('fields.reference')),
                            TextInput::make('district')->label(__('fields.district')),
                            TextInput::make('city')->label(__('fields.city')),
                            TextInput::make('state')->label(__('fields.state')),
                        ])
                        ->columns(2),
                    Textarea::make('note')
                        ->label('Observação')
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
        ];
    }
}
