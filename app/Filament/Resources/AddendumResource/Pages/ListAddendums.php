<?php

namespace App\Filament\Resources\AddendumResource\Pages;

use App\Filament\Resources\AddendumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddendums extends ListRecords
{
    protected static string $resource = AddendumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
