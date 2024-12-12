<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WoocommerceProductImportButton extends Widget
{
    protected static string $view = 'filament.widgets.woocommerce-product-import-button';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 5,
    ];



    protected function getHeading(): ?string
    {
        return 'Analytics';
    }
}
