<?php

namespace App\Filament\Resources\AddendumResource\Pages;

use App\Filament\Resources\AddendumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddendum extends EditRecord
{
    protected static string $resource = AddendumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
