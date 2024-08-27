<?php

namespace App\Filament\Forms;

use App\Models\Cnae;
use App\Models\Contract;
use App\Models\Sending;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;

class SendingForm
{
    public static function form(): array
    {
        return [
            Section::make('Dados do Envio')
                ->description(
                    fn(string $operation): string => $operation === 'create' || $operation === 'edit' ? 'Informe os campos solicitados' : ''
                )
                ->schema([
                    DatePicker::make('emission_date')
                        ->label('Data de Emissão')
                        ->required()
                        ->default(now()),
                    TextInput::make('rps')
                        ->label('N° do RPS')
                        ->required()
                        ->default(function () {
                            $maxNumber = Sending::max('number');
                            return $maxNumber ? $maxNumber + 1 : 2; // Incrementa o valor máximo ou inicia com 2 se não houver registros
                        })
                        ->numeric(),
                    DatePicker::make('competence_date')
                        ->label('Competência')
                        ->required()
                        ->default(now()),
                    TextInput::make('situation_description')
                        ->label('Situação')
                        ->visibleOn('view')
                        ->reactive()
                        ->afterStateHydrated(function ($record, callable $set) {
                            if (isset($record)) {
                                switch ($record->situation) {
                                    case 1:
                                        $set('situation_description', '1 - Não Recebido');
                                        break;
                                    case 2:
                                        $set('situation_description', '2 - Não Processado');
                                        break;
                                    case 3:
                                        $set('situation_description', '3 - Processado com erro');
                                        break;
                                    case 4:
                                        $set('situation_description', '4 - Processado com sucesso');
                                        break;
                                    default:
                                        $set('situation_description', 'Texto padrão para outras situações');
                                }
                            }
                        })
                        ->default(1),
                    DateTimePicker::make('date')
                        ->label('Data de Recebimento')
                        ->visibleOn('view'),
                    TextInput::make('protocol')
                        ->label('Protocolo')
                        ->visibleOn('view')
                        ->maxLength(255),
                    Select::make('cnae_id')
                        ->label('Serviço')
                        ->options(Cnae::all()->pluck('description', 'id')->mapWithKeys(function ($description, $id) {
                            $cnae = Cnae::find($id);
                            $description = Str::words($cnae->description, 12); // Limita a descrição a 5 palavras
                            return [$id => "{$cnae->number} {$cnae->code} - {$description}"];
                        }))->columnSpanFull()
                        ->required(),
                    Select::make('contract_id')
                        ->label('Contrato')
                        ->searchable()
                        ->required()
                        ->preload()
                        ->relationship('contract')
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $contract = Contract::find($get('contract_id'));
                            $monthlyValue = $contract->monthly_value ? $contract->monthly_value : 0;
                            $set('value', number_format((float)$monthlyValue, 2, '.', ''));

                            // $netValue = (float) $get('value') - ((float) $get('aliquot') * (float) $get('value')) / 100;
                            // $iss = ((float) $get('aliquot') * (float) $get('value')) / 100;

                            // $set('iss_value', number_format((float)$iss, 2, '.', ''));
                            // $set('net_value', number_format((float)$netValue, 2, '.', ''));
                        })
                        ->live(debounce: 500)
                        ->columnSpanFull()
                        ->getOptionLabelFromRecordUsing(fn(Contract $contract) => "{$contract->number} - {$contract->client->name}"),
                    TextInput::make('value')
                        ->label('Valor Total')
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $netValue = (float) $get('value') - ((float) $get('aliquot') * (float) $get('value')) / 100;
                            $iss = ((float) $get('aliquot') * (float) $get('value')) / 100;

                            $set('iss_value', number_format((float)$iss, 2, '.', ''));
                            $set('net_value', number_format((float)$netValue, 2, '.', ''));
                            $set('value', number_format((float)$get('value'), 2, '.', ''));
                        })
                        ->live(debounce: 1000)
                        ->required()
                        ->numeric(),
                    // TextInput::make('aliquot')
                    //     ->label('Alíquota')
                    //     ->afterStateUpdated(function (Set $set, Get $get) {
                    //         $netValue = (float) $get('value') - ((float) $get('aliquot') * (float) $get('value')) / 100;
                    //         $iss = ((float) $get('aliquot') * (float) $get('value')) / 100;

                    //         $set('iss_value', number_format((float)$iss, 2, '.', ''));
                    //         $set('net_value', number_format((float)$netValue, 2, '.', ''));
                    //         $set('value', number_format((float)$get('value'), 2, '.', ''));
                    //     })
                    //     ->default(2.0)
                    //     ->live(debounce: 500)
                    //     ->required()
                    //     ->numeric(),
                    // TextInput::make('iss_value')
                    //     ->label('Valor ISS')
                    //     ->live()
                    //     ->readOnly()
                    //     ->numeric(),
                    // TextInput::make('net_value')
                    //     ->label('Valor Líquido')
                    //     ->live()
                    //     ->readOnly()
                    //     ->numeric(),
                    Textarea::make('info')
                        ->label('Detalhamento do Serviço')
                        ->maxLength(65535)
                        ->columnSpanFull(),


                ])->columns(2),
        ];
    }
}
