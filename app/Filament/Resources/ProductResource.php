<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductResource\Pages;

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
                Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                TextInput::make('price')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('product_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('index')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('producer')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mechanical_parameters_width')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mechanical_parameters_height')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mechanical_parameters_thickness')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mechanical_parameters_weight')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ean_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            ]);
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
