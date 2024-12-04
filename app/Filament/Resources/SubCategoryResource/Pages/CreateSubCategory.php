<?php

declare(strict_types=1);

namespace App\Filament\Resources\SubCategoryResource\Pages;

use App\Filament\Resources\SubCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubCategory extends CreateRecord
{
    protected static string $resource = SubCategoryResource::class;
}
