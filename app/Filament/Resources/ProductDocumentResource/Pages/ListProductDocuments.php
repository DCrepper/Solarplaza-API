<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductDocumentResource\Pages;

use App\Filament\Resources\ProductDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductDocuments extends ListRecords
{
    protected static string $resource = ProductDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
