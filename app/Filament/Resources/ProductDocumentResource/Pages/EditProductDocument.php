<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductDocumentResource\Pages;

use App\Filament\Resources\ProductDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductDocument extends EditRecord
{
    protected static string $resource = ProductDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
