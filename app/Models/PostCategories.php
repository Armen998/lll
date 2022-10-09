<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'post_id',
        'category_id',
    ];

    //User
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    //User
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
