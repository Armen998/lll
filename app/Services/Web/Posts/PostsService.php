<?php

namespace App\Services\Web\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategories;
use App\Models\PostComment;
use App\Models\PostOpinion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostsService
{
    protected $userModel;

    protected $postModel;

    protected $categoryModel;

    protected $postCategoryModel;

    protected $postOpinionModel;



    public function __construct(Category $categoryModel, Post $postModel, User $userModel, PostOpinion $postOpinionModel, PostCategories $postCategoryModel)
    {
        $this->postCategoryModel = $postCategoryModel;

        $this->postOpinionModel = $postOpinionModel;

        $this->categoryModel = $categoryModel;

        $this->postModel = $postModel;

        $this->userModel = $userModel;
    }

    //Post Create
    public function all_categoris()
    {
        $categories = $this->categoryModel::get(['id', 'title',]);

        return [
            'categories' => $categories,
        ];
    }

    public function create($createPostData)
    {
        foreach ($createPostData['categories'] as $category_id)

            $checkId = $this->categoryModel::where(['id' =>  $category_id])->get(['id'])->toArray();

        if (!empty($checkId)) {

            DB::transaction(function () use ($createPostData) {

                $createdPostData = [
                    'user_id' => auth('web')->id(),
                    'title' => $createPostData['title'],
                    'description' => $createPostData['description'],
                    'status' => $createPostData['status'],
                ];

                $createdPost = $this->postModel::create($createdPostData);

                foreach ($createPostData['categories'] as $category_id) {
                    $createdPostCategories = $this->postCategoryModel::create(['post_id' =>  $createdPost->id, 'category_id' => $category_id]);
                }

                if ($createdPost && $createdPostCategories) {
                    DB::commit();
                }
            }, 3);
            return true;
        } else {
            return false;
        }
    }

    public function statedCategory($id)
    {
        $categories = $this->categoryModel::where(['id' => $id])->get(['id', 'title',]);

        return [
            'categories' => $categories,
        ];
    }

    public function statedCreate($createPostData, $id)
    {

        $checkId = $this->categoryModel::where(['id' =>  $id])->first(['id']);

        if (!empty($checkId)) {

            DB::transaction(function () use ($createPostData, $id) {

                $createdPostData = [
                    'user_id' => auth('web')->id(),
                    'title' => $createPostData['title'],
                    'description' => $createPostData['description'],
                    'status' => $createPostData['status'],
                ];

                $createdPost = $this->postModel::create($createdPostData);

                $createdPostCategories = $this->postCategoryModel::create(['post_id' =>  $createdPost->id, 'category_id' => $id]);

                if ($createdPost && $createdPostCategories) {
                    DB::commit();
                }
            }, 3);
            return true;
        } else {
            return false;
        }
    }

    //Post view
    public function view($id)
    {
        $categories = $this->categoryModel::with([
            'user',
            'postCategoris.post.user',
            'postCategoris.post.postComments' => function ($query) use ($id) {
                $query->where(['post_id' => $id]);
            },
            'postCategoris.post.postOpinion' => function ($query) {
                $query->where(['user_id' => auth('web')->id()]);
            }
        ])->get();

        return [
            'categories' => $categories,
        ];
    }

    public function addPost()
    {
        $users = auth('web')->id();

        $user = $this->userModel::with(['posts' => function ($query) {
            $query->where(['user_id' => auth('web')->id()]);
        }])->where(['id' => auth('web')->id()])->get(['id', 'name', 'age', 'email',]);

        return [
            'users' => $users,
            'user' => $user
        ];
    }

    public function updatedPost($id)
    {
        $categories = $this->categoryModel::with([
            'user',
            'postCategoris.post.user',
            'postCategoris.post.postComments',
            'postCategoris.post.postOpinion',
        ])->get();


        $posts = $this->postModel::with([
            'user',
            'postCategoris',
            'postComments',
            'postOpinion',
        ])->where(['id' => $id])->first();

        if ($posts->user_id === auth('web')->id()) {
            return [
                'categories' => $categories,
                'posts' => $posts
            ];
        }
        return false;
    }

    public function update($id, $updatedData)
    {
        $postData = $this->postModel::where(['id' => $id], ['user_id'] === auth('web')->id())->first(['title', 'description', 'status']);

        $checkTitle = $this->postModel::where(['title' => $updatedData['title']])->first(['title']);

        if (!empty([$postData, $updatedData]) && empty($checkTitle) || $checkTitle->title === $postData->title) {
            $this->postModel::find($id)->update($updatedData);
            return true;
        }
        return false;
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

    public function destroy($id)
    {
        $deleteInPost = $this->postModel::find($id)->delete();

        if ($deleteInPost) {
            return true;
        } else {
            return false;
        }
    }
}
