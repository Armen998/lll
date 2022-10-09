<?php

namespace App\Services\Web\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\PostComment;
use App\Models\PostOpinion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostsOpinionsService
{
    protected $userModel;

    protected $postModel;

    protected $postCategoryModel;

    protected $postOpinionModel;

    protected $postOpinionCountModel;

    public function __construct(Category $categoryModel, Post $postModel, User $userModel, PostComment $postCommentModel, PostOpinion $postOpinionModel, PostCategories $postCategoryModel)
    {
        $this->postCategoryModel = $postCategoryModel;

        $this->postOpinionModel = $postOpinionModel;

        $this->postCommentModel = $postCommentModel;

        $this->categoryModel = $categoryModel;

        $this->postModel = $postModel;

        $this->userModel = $userModel;
    }

    public function like($id)
    {
        $post = $this->postModel::where(['id' => $id])->first();

        $checkLikeDislike =  $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->first();

        if (empty($checkLikeDislike)) {
            DB::transaction(function () use ($post, $id) {
                $opinionData = [
                    'user_id' => auth('web')->id(),
                    'post_id' => $id,
                    'is_like' => 1,
                    'is_dislike' => 0,
                ];
                $created = $this->postOpinionModel::create($opinionData);

                $updated =  $this->postModel::where(['id' => $id])->update(['likes_counts' => $post->likes_counts + 1, 'updated_at' => $post->updated_at]);
                if ($created && $updated) {
                    DB::commit();
                }
            }, 3);
        } else {
            if ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 1) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts = $this->postModel::where(['id' => $id])->update(['likes_counts' => $post->likes_counts + 1, 'dislikes_counts' => $post->dislikes_counts - 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion = $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 1, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 1 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts = $this->postModel::where(['id' => $id])->update(['likes_counts' => $post->likes_counts - 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion =  $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 0, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts = $this->postModel::where(['id' => $id])->update(['likes_counts' => $post->likes_counts + 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion = $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 1, 'is_dislike' => 0]);
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
        $post = $this->postModel::where(['id' => $id])->first();

        $checkLikeDislike =  $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->first();

        if (empty($checkLikeDislike)) {
            DB::transaction(function () use ($post, $id) {
                $opinionData = [
                    'user_id' => auth('web')->id(),
                    'post_id' => $id,
                    'is_like' => 0,
                    'is_dislike' => 1,
                ];
                $created = $this->postOpinionModel::create($opinionData);

                $updated =  $this->postModel::where(['id' => $id])->update(['dislikes_counts' =>  $post->dislikes_counts + 1, 'updated_at' => $post->updated_at]);
                if ($created && $updated) {
                    DB::commit();
                }
            }, 3);
        } else {
            if ($checkLikeDislike->is_like === 1 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts =  $this->postModel::where(['id' => $id])->update(['likes_counts' =>  $post->likes_counts - 1, 'dislikes_counts' =>  $post->dislikes_counts + 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion = $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 0, 'is_dislike' => 1]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 1) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts = $this->postModel::where(['id' => $id])->update(['dislikes_counts' =>  $post->dislikes_counts - 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion = $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 0, 'is_dislike' => 0]);
                    if ($updatedCounts && $updatedOpinion) {
                        DB::commit();
                    }
                }, 3);
            } elseif ($checkLikeDislike->is_like === 0 && $checkLikeDislike->is_dislike === 0) {
                DB::transaction(function () use ($post, $id) {
                    $updatedCounts = $this->postModel::where(['id' => $id])->update(['dislikes_counts' =>  $post->dislikes_counts + 1, 'updated_at' => $post->updated_at]);
                    $updatedOpinion = $this->postOpinionModel::where(['user_id' => auth('web')->id(), 'post_id' => $id])->update(['is_like' => 0, 'is_dislike' => 1]);
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
