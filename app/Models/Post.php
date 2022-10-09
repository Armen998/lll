<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;



class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'likes_counts',
        'dislikes_counts',
        'comments_counts',
    ];

    //User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Categoris
    public function postCategoris()
    {
        return $this->hasMany(PostCategories::class);
    }

    //Post post
    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }

    //LikeDiclike
    public function postOpinion()
    {
        return $this->hasMany(PostOpinion::class);
    }

    //PostFavorite
    public function postFavorite()
    {
        return $this->hasMany(PostFavorite::class);
    }
}
