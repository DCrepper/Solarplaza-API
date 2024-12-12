<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Collection;

class StatOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        $products = Product::all();
        $newProducts = $this->getNewProducts();
        $newProductsCount = $newProducts->count();
        $newProductsChartData = $this->getChartData($newProducts);

        $updatedProducts = $this->getUpdatedProducts();
        $updatedProductsCount = $updatedProducts->count();
        $updatedProductsChartData = $this->getChartData($updatedProducts);

        return [
            Stat::make(__('Összes Termék'), $products->count())
                ->description('Összes termék darabszáma')
                ->chart([1, 1, 1, 1, 1, 1, 1, 1]),
            Stat::make(__('Új termékek az elmult 24 órában'), $newProductsCount)
                ->description(__('Az elmult 24 órában hozzáadott termékek darabszáma'))
                ->chart($newProductsChartData)
                ->color('info'),
            Stat::make(__('Frissített termékek az elmult 24 órában'), $updatedProductsCount)
                ->description(__('Az elmult 24 órában frissített termékek darabszáma'))
                ->chart($updatedProductsChartData)
                ->color('info'),
        ];
    }

    protected function getNewProducts(): Collection
    {
        return Product::where('created_at', '>=', now()->subDay())->get();
    }

    protected function getUpdatedProducts(): Collection
    {
        return Product::where('updated_at', '>=', now()->subDay())->get();
    }

    protected function getChartData($products): array
    {
        $productsLastTwentyFourHours = $products->groupBy(function ($product) {
            $hour = $product->created_at->hour;
            $group = intdiv($hour, 4) * 4;

            return $product->created_at->format('Y-m-d') . ' ' . str_pad((string)$group, 2, '0', STR_PAD_LEFT) . ':00:00';
        });

        $productsGrouped = $productsLastTwentyFourHours->map(function ($group) {
            return $group->count();
        })->toArray();

        $chartData = array_fill(0, 6, 0);
        foreach ($productsGrouped as $key => $count) {
            $hour = (int) substr($key, 11, 2);
            $index = intdiv($hour, 4);
            $chartData[$index] = $count;
        }

        $currentHour = now()->hour;
        $currentIndex = intdiv($currentHour, 4);

        return array_merge(array_slice($chartData, $currentIndex + 1), array_slice($chartData, 0, $currentIndex + 1));
    }
}
