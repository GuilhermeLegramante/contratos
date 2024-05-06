<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AdjustmentIndexForm
{
    public static function form(): array
    {
        return [
            TextInput::make('name')
                ->label('Nome')
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
            Textarea::make('note')
                ->label('Observação')
                ->maxLength(65535)
                ->columnSpanFull(),
        ];
    }
}
