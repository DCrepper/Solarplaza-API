<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 *
 * @property int $id
 * @property int $product_id
 * @property string $description
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDocument whereUrl($value)
 * @mixin \Eloquent
 */
class ProductDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'url',
        'type', // New field
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
