<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductDocumentResource\Pages;

use App\Filament\Resources\ProductDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductDocument extends CreateRecord
{
    protected static string $resource = ProductDocumentResource::class;
}
