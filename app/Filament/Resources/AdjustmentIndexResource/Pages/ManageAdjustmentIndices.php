<?php

namespace App\Filament\Resources\AdjustmentIndexResource\Pages;

use App\Filament\Resources\AdjustmentIndexResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAdjustmentIndices extends ManageRecords
{
    protected static string $resource = AdjustmentIndexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
