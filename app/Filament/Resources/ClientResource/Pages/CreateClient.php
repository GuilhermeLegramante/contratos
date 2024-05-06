<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected static ?string $navigationLabel = 'Criar Cliente';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
