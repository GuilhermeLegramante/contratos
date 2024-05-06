<?php

namespace App\Filament\Resources\HiringMethodResource\Pages;

use App\Filament\Resources\HiringMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHiringMethods extends ManageRecords
{
    protected static string $resource = HiringMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
