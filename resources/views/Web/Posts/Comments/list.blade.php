<div style=" width:  100%; margin-top: 20px  ">
    <section style="background-color: rgb(243, 245, 230);">
        <div class="container ">
            <div class="row d-flex justify-content-center" style="width: 103.4%">
                <div class="col-md-12 col-lg-8 col-xl-11" style="padding-right: 0px !important">
                    <div class="card" style="background-color: rgb(243, 245, 235);">
                        <div class="card-body">
                            <div>
                                <div class="d-flex flex-start align-items-center">
                                    @if ($comment->user->avatar !== null)
                                    <img class="avatar" src="{{ asset('/storage/' . $comment->user->avatar ) }}">
                                    @else
                                    <img class="avatar" src="{{ asset('/storage/icon/avatar.png') }}">
                                    @endif
                                    <div>
                                        <p class=" text-info font-italic mb-2 h4"> {{ $comment->user->name }} </p>
                                        <p class="text-muted small mb-0">
                                            Shared publicly - {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class=" text-muted mt-3 col-mb-4 col-md-6  pb-2 h4">
                                        {{ $comment->text }}
                                    </p>
                                    <div class="small d-flex justify-content-start">
                                        @if($comment->user_id === auth('web')->id() || auth('web')->user()->type === 'admin')
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->likes_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <i style="font-size:36px; color:blue" class="fa-regular text-center fa-thumbs-up"></i>
                                            </p>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->dislikes_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <i style="font-size:36px; color:black ; width: 5rem" class="fa-regular text-center fa-thumbs-down"> </i>
                                            </p>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->comments_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                    <i style="font-size:36px;" class="far text-info text-center fa-comment-dots me-2"></i>
                                            </p>
                                        </div>
                                        @else
                                        {{--  @dd($comment->postOpinion)  --}}
                                        @if ($comment)
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->likes_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <form action="{{ route('posts-comments-like', ['id' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="onclick" class="success " id="success-outlined{{ $comment->id . '1' }}">
                                                        <i style="font-size:36px; color:blue" class="fa-regular fa-thumbs-up"></i>
                                                    </button>
                                                </form>
                                            </p>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->dislikes_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <form action="{{ route('posts-comments-dislike', ['id' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="onclick" class="" id="danger-outlined{{ $comment->id }}">
                                                        <i style="font-size:36px; color:black ; width: 5rem" class="fa-regular fa-thumbs-down"> </i>
                                                    </button>
                                                </form>
                                            </p>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->comments_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <i style="font-size:36px;" class="far text-info text-center fa-comment-dots me-2"></i>
                                            </p>
                                        </div>
                                        @else
                                        @if ($comment->postOpinion[0]->is_like === 1)
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->likes_counts }} </p>
                                            <form action="{{ route('posts-comments-like', ['id' => $comment->id]) }}" method="POST">
                                                @csrf
                                                <button type="onclick" class="success" id="success-outlined{{ $comment->id . '1' }}">
                                                    <i style="font-size:36px; color:blue " class="fa-solid  fa-thumbs-up"> </i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->dislikes_counts }} </p>
                                            <form action="{{ route('posts-comments-dislike', ['id' => $comment['id']]) }}" method="POST">
                                                @csrf
                                                <button type="onclick" class="" id="danger-outlined{{ $comment->id }}">
                                                    <i style="font-size:36px; color:black ; width:5rem" class="fa-regular fa-thumbs-down"> </i>
                                                </button>
                                            </form>
                                            </p>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->comments_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <i style="font-size:36px;" class="far text-info text-center fa-comment-dots me-2"></i>
                                            </p>
                                        </div>
                                        @elseif ($comment->postOpinion[0]->is_dislike === 1)
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->likes_counts }} </p>
                                            <form action="{{ route('posts-comments-like', ['id' => $comment->id]) }}" method="POST" class="">
                                                @csrf
                                                <button type="onclick" class="success" id="success-outlined{{ $comment->id . '1' }}">
                                                    <i style="font-size:36px; color:blue" class="fa-regular fa-thumbs-up"> </i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->dislikes_counts }} </p>
                                            <form action="{{ route('posts-comments-dislike', ['id' => $comment->id]) }}" method="POST">
                                                @csrf
                                                <button type="onclick" class="" id="danger-outlined{{ $comment->id }}">
                                                    <i style="font-size:36px; color:black ; width:5rem" class="fas fa-thumbs-down"> </i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->comments_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                    <i style="font-size:36px;" class="far text-info text-center fa-comment-dots me-2"></i>
                                            </p>
                                        </div>
                                        @else
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->likes_counts }} </p>
                                            <form action="{{ route('posts-comments-like', ['id' => $comment->id]) }}" method="POST">
                                                @csrf
                                                <button type="onclick" class=" success" id="success-outlined{{ $comment->id . '1' }}">
                                                    <i style="font-size:36px; color:blue" class="fa-regular fa-thumbs-up"> </i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->dislikes_counts }} </p>
                                            <form action="{{ route('posts-comments-dislike', ['id' => $comment->id]) }}" method="POST">
                                                @csrf
                                                <button type="onclick" class=" " id="danger-outlined{{ $comment->id }}">
                                                    <i style="font-size:36px; color:black; width:5rem" class="fa-regular fa-thumbs-down"> </i>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class=" text-info font-italic text-center mb-2 h4"> {{ $comment->comments_counts }} </p>
                                            <p class="text-muted small mb-0">
                                                <i style="font-size:36px;" class="far text-info text-center fa-comment-dots me-2"></i>
                                            </p>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                    </div>
                                    <div>
                                        <div class="my-2 ">
                                            <form action="{{ route('posts-comments-reply', ['id' => $post ->id, 'comment_id' => $comment->id]) }}" method="POST">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="submite" class="form-control" placeholder="Reply to comments" name="text" style=" width:5rem;">
                                                    <button class="" type="submit"> <i style="font-size:36px; width:5rem; color:green " class="fa-solid  fa-comment"> </i> </button>
                                                    <button class="" type="reset"> <i style="font-size:36px; width:5rem; color: orange" class="fa-solid  fa-comment-slash"> </i> </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $i ++
                    @endphp
                    @if(!empty($comment->comments->toArray()))
                    @foreach ( $comment->comments as $comment )
                    @include( 'Web/Posts/Comments/list', [ 'comment' => $comment, 'i' => $i ])
                    @endforeach
                    @endif
                </div>
            </div>
    </section>
</div>
