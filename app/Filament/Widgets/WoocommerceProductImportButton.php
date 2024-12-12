<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Jobs\UpdateWoocomerceNameSwitchedProductJob;
use Filament\Widgets\Widget;

class WoocommerceProductImportButton extends Widget
{
    protected static string $view = 'filament.widgets.woocommerce-product-import-button';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 5,
    ];



    public function startImportWoocommerceSwitchedProducts()
    {
        //start import woocommerce products to woocommerce only that
        //products which are in switched the name and description
        //update that products i think we need to use the woocommerce api and job
        //queue for this task
        UpdateWoocomerceNameSwitchedProductJob::dispatch();

    }


}
