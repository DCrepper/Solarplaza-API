<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'group',
        'name',
        'index',
        'ean_code',
        'urls',
    ];

    protected $casts = [
        'urls' => 'array',
    ];
}
