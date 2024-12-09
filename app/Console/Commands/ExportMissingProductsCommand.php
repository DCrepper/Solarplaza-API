<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExportMissingProducts;

class ExportMissingProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:missing-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export products that are in the local database but not in WooCommerce';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ExportMissingProducts::dispatch();

        $this->info('Export job dispatched successfully.');
    }
}
