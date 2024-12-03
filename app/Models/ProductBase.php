<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'index',
        'logistic_parameters',
        'weight', // New field
        'dimensions', // New field
    ];

    protected $casts = [
        'logistic_parameters' => 'array',
        'dimensions' => 'array', // New cast
    ];
}
