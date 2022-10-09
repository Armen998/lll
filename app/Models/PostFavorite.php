<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    //User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Post
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
