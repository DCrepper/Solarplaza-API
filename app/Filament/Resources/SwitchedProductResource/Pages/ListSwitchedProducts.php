<?php

declare(strict_types=1);

namespace App\Filament\Resources\SwitchedProductResource\Pages;

use App\Filament\Resources\SwitchedProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSwitchedProducts extends ListRecords
{
    protected static string $resource = SwitchedProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
