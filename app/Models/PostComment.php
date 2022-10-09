<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'text',
        'likes_counts',
        'dislikes_counts',
        'comments_counts',
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

    //Comment
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'parent_id', 'id');
    }

    public function parent_comment()
    {
        return $this->belongsTo(PostComment::class, 'parent_id', 'id');
    }

     //LikeDiclike
     public function postCommentOpinion()
     {
         return $this->hasMany(PostCommentOpinion::class);
     }
}
