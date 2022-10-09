<?php

namespace App\Services\Web\Posts\Comments;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\DB;

class PostsCommentsService
{
    protected $postCommentModel;

    protected $postModel;

    public function __construct(Post $postModel, PostComment $postCommentModel,)
    {
        $this->postCommentModel = $postCommentModel;

        $this->postModel = $postModel;

    }

    //Add Comment
    public function create( $createdData, $id)
    {
        $post = $this->postModel::where(['id' => $id])->first();

        DB::transaction(function () use ($post, $id, $createdData) {
             $commentData = [
                'user_id' => auth('web')->id(),
                'post_id' => $id,
                'parent_id' => NULL,
                'text' => $createdData['text'],  
            ];
            $created = $this->postCommentModel::create($commentData);

            $updated = $this->postModel::where(['id' => $id])->update(['comments_counts' => $post->comments_counts + 1, 'updated_at' => $post->updated_at]);
           if($created && $updated) {
            DB::commit();
            return true;
           }
        },3);
       return false;
    }

    public function reply( $comment_id, $createdData, $id)
    {
        $post = $this->postModel::where(['id' => $id])->first();

        DB::transaction(function () use ($post, $comment_id, $createdData, $id) {
             $commentData = [
                'user_id' => auth('web')->id(),
                'post_id' => $id,
                'parent_id' => $comment_id,
                'text' => $createdData['text'],  
            ];
            $created = $this->postCommentModel::create($commentData);

            $updated = $this->postModel::where(['id' => $id])->update(['comments_counts' => $post->comments_counts + 1, 'updated_at' => $post->updated_at]);
           if($created && $updated) {
            DB::commit();
            return true;
           }
        },3);
       return false;
    }
}

