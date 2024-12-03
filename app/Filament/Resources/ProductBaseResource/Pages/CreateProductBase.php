<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductBaseResource\Pages;

use App\Filament\Resources\ProductBaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductBase extends CreateRecord
{
    protected static string $resource = ProductBaseResource::class;
}
