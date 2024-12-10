<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Jobs\UploadProductsToWooCommerce;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('product_id'),
                TextInput::make('sub_category_id')
                    ->numeric(),
                TextInput::make('index'),
                TextInput::make('name'),
                TextInput::make('producer'),
                TextInput::make('document'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                TextInput::make('price')
                    ->prefix('$'),
                TextInput::make('mechanical_parameters_width'),
                TextInput::make('mechanical_parameters_height'),
                TextInput::make('mechanical_parameters_thickness'),
                TextInput::make('mechanical_parameters_weight'),
                TextInput::make('ean_code'),
                TextInput::make('stock')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')
                    ->searchable(),
                TextColumn::make('sub_category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('index')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('producer')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                TextColumn::make('price')
                    ->sortable(),
                TextColumn::make('mechanical_parameters_width')
                    ->searchable(),
                TextColumn::make('mechanical_parameters_height')
                    ->searchable(),
                TextColumn::make('mechanical_parameters_thickness')
                    ->searchable(),
                TextColumn::make('mechanical_parameters_weight')
                    ->searchable(),
                TextColumn::make('ean_code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('document')
                ->searchable()
                ->sortable(),
                TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([10, 25, 50, 100]);
    }

    public static function chunkAndUploadProducts(): void
    {
        Product::chunk(100, function ($products) {
            $updateData = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'price' => $product->price,
                    'stock_quantity' => $product->stock,
                    'status' => 'publish',
                ];
            })->toArray();

            UploadProductsToWooCommerce::dispatch($updateData);
        });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
