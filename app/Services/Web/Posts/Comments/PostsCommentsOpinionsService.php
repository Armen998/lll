<?php

namespace App\Services\Web\Posts\Comments;

use App\Models\PostComment;
use App\Models\PostCommentOpinion;
use App\Models\PostOpinion;
use Illuminate\Support\Facades\DB;

class PostsCommentsOpinionsService
{

    protected $postCommentModel;

    protected $postCommentOpinionModel;

    public function __construct( PostComment $postCommentModel, PostCommentOpinion $postCommentOpinionModel)
    {
        $this->postCommentOpinionModel = $postCommentOpinionModel;

        $this->postCommentModel = $postCommentModel;
    }

    public function like($id)
    {
        $comment = $this->postCommentModel::where(['id' => $id])->first();

        $checkLikeDislike =  $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->first();

        if (empty($checkLikeDislike)) {
            DB::transaction(function () use ($comment, $id) {
                $opinionData = [
                    'user_id' => auth('web')->id(),
                    'comment_id' => $id,
                    'is_like' => 1,
                    'is_dislike' => 0,
                ];
                $created = $this->postCommentOpinionModel::create($opinionData);

                $updated =  $this->postCommentModel::where(['id' => $id])->update(['likes_counts' => $comment->likes_counts + 1, 'updated_at' => $comment->updated_at]);
                if ($created && $updated) {
                    DB::commit();
                }
            }, 3);
        } else {
            if ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 1) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts = $this->postCommentModel::where(['id' => $id])->update(['likes_counts' => $comment->likes_counts + 1, 'dislikes_counts' => $comment->dislikes_counts - 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion = $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 1, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 1 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts = $this->postCommentModel::where(['id' => $id])->update(['likes_counts' => $comment->likes_counts - 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion =  $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 0, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts = $this->postCommentModel::where(['id' => $id])->update(['likes_counts' => $comment->likes_counts + 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion = $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 1, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            }
            return true;
        }
        return false;
    }

    public function dislike($id)
    {
        $comment = $this->postCommentModel::where(['id' => $id])->first();

        $checkLikeDislike =  $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->first();

        if (empty($checkLikeDislike)) {
            DB::transaction(function () use ($comment, $id) {
                $opinionData = [
                    'user_id' => auth('web')->id(),
                    'comment_id' => $id,
                    'is_like' => 0,
                    'is_dislike' => 1,
                ];
                $created = $this->postCommentOpinionModel::create($opinionData);

                $updated =  $this->postCommentModel::where(['id' => $id])->update(['dislikes_counts' =>  $comment->dislikes_counts + 1, 'updated_at' => $comment->updated_at]);
                if ($created && $updated) {
                    DB::commit();
                }
            }, 3);
        } else {
            if ($checkLikeDislike->is_like === 1 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts =  $this->postCommentModel::where(['id' => $id])->update(['likes_counts' =>  $comment->likes_counts - 1, 'dislikes_counts' =>  $comment->dislikes_counts + 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion = $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 0, 'is_dislike' => 1]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 1) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts = $this->postCommentModel::where(['id' => $id])->update(['dislikes_counts' =>  $comment->dislikes_counts - 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion = $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 0, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($comment, $id) {
                    $updatedCounts = $this->postCommentModel::where(['id' => $id])->update(['dislikes_counts' =>  $comment->dislikes_counts + 1, 'updated_at' => $comment->updated_at]);
                    $updatedOpinion = $this->postCommentOpinionModel::where(['user_id' => auth('web')->id(), 'comment_id' => $id])->update(['is_like' => 0, 'is_dislike' => 1]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            }
            return true;
        }
        return false;
    }
}
