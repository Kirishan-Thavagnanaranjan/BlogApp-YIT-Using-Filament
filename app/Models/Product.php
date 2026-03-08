<?php

namespace App\Models;

use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "sku",
        "description",
        "price",
        "stock",
        "image",
        "is_active",
        "is_feautured"

    ];
}
