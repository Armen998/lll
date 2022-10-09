@extends('Web/layout')

@section('content')
<div class="container">
    <p class=" display-4  text-center"> My Posts</p>
    @if (session()->has('deleted'))
    <div class="alert alert-warning" role="alert"> {{ session()->get('deleted') }} </div>
    @endif
    @foreach ($categories as $category)
    @if ($category->user_id !== auth('web')->id() && $category->status === 0 )
    @continue;
    @endif
    @if ($category->user_id === auth('web')->id() && $category->status === 0 )
    <section style="background-color: rgb(243, 245, 230);">
        <div class="container my-6 py-6">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-8 col-xl-11">
                    <div class="card" style="background-color: rgb(246, 189, 181);">
                        <div class="card-body">
                            <p class=" text-info font-italic mb-2 display-4 ">{{ $category->title }}</p>
                            <a class="" href="{{ route('posts-stated-create',$category->id) }}"><button>Add Post</button></a>
                        </div>
                        @foreach ($category->postCategoris as $postCategoris)
                        @php $post = $postCategoris->post @endphp
                        @if ($post->block_time !== NULL)
                        @php
                        $block_time = strtotime("+7 day", strtotime($post->block_time) );
                        $presentTyme = (int) date( time());
                        @endphp
                        @if($block_time >= $presentTyme)
                        @continue;
                        @endif
                        @endif
                        @if ($post->user_id !== auth('web')->id() && $post->status === 0 )
                        @continue;
                        @endif
                        <section style="background-color: rgb(246, 189, 181);">
                            <div class="container my-6 py-6">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-lg-8 col-xl-11">
                                        <div class="card" style="background-color: rgb(246, 189, 181);">
                                            <div class="card-body">
                                                @include('Web/repeatitions.post', ['post' => $post])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    <section style="background-color: rgb(243, 245, 230);">
        <div class="container my-6 py-6">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-8 col-xl-11">
                    <div class="card" style="background-color: rgb(243, 245, 235);">
                        <div class="card-body">
                            <p class=" text-info font-italic mb-2 display-4 ">{{ $category->title }}</p>
                            <a class="" href="{{ route('posts-stated-create',$category->id) }}"><button>Add Post</button></a>
                        </div>
                        @foreach ($category->postCategoris as $postCategoris)
                        @php $post = $postCategoris->post @endphp
                        @if ($post->block_time !== NULL)
                        @php
                        $block_time = strtotime("+7 day", strtotime($post->block_time) );
                        $presentTyme = (int) date( time());
                        @endphp
                        @if($block_time >= $presentTyme)
                        @continue;
                        @endif
                        @endif
                        @if ($post->user_id !== auth('web')->id() && $post->status === 0 )
                        @continue;
                        @endif
                        <section style="background-color: rgb(243, 245, 230);">
                            <div class="container my-6 py-6">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-lg-8 col-xl-11">
                                        <div class="card" style="background-color: rgb(243, 245, 235);">
                                            <div class="card-body">
                                                @include('Web/repeatitions.post', ['post' => $post])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @endforeach
</div>
@endsection
