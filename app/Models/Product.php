<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $product_id
 * @property int $subcategory_id
 * @property string $index
 * @property string $name
 * @property string $producer
 * @property string $warranty_extension_for_product_index
 * @property string $description
 * @property string $image
 * @property int $price
 * @property string $mechanical_parameters_width
 * @property string $mechanical_parameters_height
 * @property string $mechanical_parameters_thickness
 * @property string $mechanical_parameters_weight
 * @property string $ean_code
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subcategory|null $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMechanicalParametersHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMechanicalParametersThickness($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMechanicalParametersWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMechanicalParametersWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWarrantyExtensionForProductIndex($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sub_category_id',
        'index',
        'name',
        'producer',
        'description',
        'image',
        'price',
        'mechanical_parameters_width',
        'mechanical_parameters_height',
        'mechanical_parameters_thickness',
        'mechanical_parameters_weight',
        'ean_code',
        'stock',

    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
