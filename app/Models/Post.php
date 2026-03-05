<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\category;


class Post extends Model
{
    protected $fillable = [
        "title",
        "slug",
        "category_id",
        "image",
        "color",
        "body",
        "tags",
        "published",
        "published_at"
    ];

    protected $casts = [
        "tags" => "array" ,
        "published" => "boolean",
        "published_at" => "date"
    ];

    public function category() {
        return $this ->belongsTo(category::class);
    }
}
