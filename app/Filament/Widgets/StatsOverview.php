<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $activeContracts = Contract::where('is_active', 1)->count();

        $monthlyTotal = Contract::where('is_active', 1)->sum('monthly_value');

        $startDate = Carbon::now()->subMonths(12);
        $finalDate = Carbon::now();

        $yearTotal = Contract::where('is_active', 1)->whereBetween('start_date', [$startDate, $finalDate])
            ->sum('monthly_value');

        return [
            Stat::make('Total Mensal', 'R$ ' . number_format($monthlyTotal, 2, ',', '.')),
            // Stat::make('Total Últimos 12 meses', 'R$ ' .  number_format($yearTotal, 2, ',', '.')),
            Stat::make('Contratos Ativos', $activeContracts),
        ];
    }
}
