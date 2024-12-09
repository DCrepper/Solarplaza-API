<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Filament\Resources\ProductResource;
use App\Jobs\ImportProductsJob;

class ImportProductsWidget extends Widget
{
    protected static string $view = 'filament.widgets.import-products-widget';

    public function importProducts()
    {

    }
    public function uploadProducts()
    {
        ProductResource::chunkAndUploadProducts();
    }

    public function startImportJob()
    {
        ImportProductsJob::dispatch();
    }
}
