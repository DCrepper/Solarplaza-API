<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductBaseResource\Pages;

use App\Filament\Resources\ProductBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductBases extends ListRecords
{
    protected static string $resource = ProductBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
