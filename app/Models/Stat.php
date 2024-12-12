<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['name', 'value'];

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeValue($query, $value)
    {
        return $query->where('value', $value);
    }

    public function scopeNameValue($query, $name, $value)
    {
        return $query->where('name', $name)->where('value', $value);
    }


}
