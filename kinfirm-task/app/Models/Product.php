<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',         // Add this field
        'description',
        'size',        // Add this field
        'photo',       // Add this field
        'updated_at',
    ];

    // Optionally define relationships if needed
}
