<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentOpinion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'is_like',
        'is_dislike',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postcomment()
    {
        return $this->belongsTo(PostComment::class);
    }
}
