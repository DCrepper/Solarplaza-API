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
    ];

    protected $casts = [
        'logistic_parameters' => 'array',
    ];
}
