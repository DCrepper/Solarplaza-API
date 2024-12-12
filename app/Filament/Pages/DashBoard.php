<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use App\Filament\Widgets\StatOverviewWidget;
use App\Filament\Widgets\ImportProductsWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use App\Filament\Widgets\WoocommerceProductImportButton;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;

class DashBoard extends BaseDashboard
{
    use HasFiltersAction;

    public function getColumns(): int|string|array
    {
        return 12;
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('1h')
                    ->action(fn () => $this->redirect(route('filament.manager.pages.dashboard'))),
                Action::make('24h')
                    ->action(fn () => $this->redirect(route('filament.manager.pages.dashboard', ['period' => '24_hours']))),
                Action::make('7d')
                    ->action(fn () => $this->redirect(route('filament.manager.pages.dashboard', ['period' => '7_days']))),
            ])
                ->label(__('Filter'))
                ->icon('heroicon-m-funnel')
                ->size(ActionSize::Small)
                ->color('gray')
                ->button()
        ];
    }

    public function getWidgets(): array
    {
        return [
            StatOverviewWidget::class,
            WoocommerceProductImportButton::class,
            ImportProductsWidget::class,
            PulseServers::class,
            PulseCache::class,
            PulseExceptions::class,
            PulseUsage::class,
            PulseQueues::class,
            PulseSlowQueries::class,
            PulseSlowRequests::class,
            PulseSlowOutGoingRequests::class
        ];
    }
}
