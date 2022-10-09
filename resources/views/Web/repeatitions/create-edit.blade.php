<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Source Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles/layout.css">
    <link rel="stylesheet" href="/styles/modal.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <a href="{{ route('home') }}">
                <img class="home" src="{{asset('/storage/icon/home.png')  }}">
            </a>
            <a class="dropdown " id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (!empty(auth('web')->user()->avatar))
                <div class="d-flex">
                    <img src="{{ asset('/storage/' . auth('web')->user()->avatar) }}" class="avatar">
                    <p class=" my-auto h4 text-info font-italic">
                        {{ auth('web')->user()->name }}
                    </p>
                </div>
                @else
                <div class="btn btn-warning text-white">
                    {{ auth('web')->user()->name }}
                </div>
                @endif
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('users', [($id = auth('web')->id())]) }}">Profile </a>
                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </nav>
    <div class="split left">
        <div>
            @if (auth('web')->user()->avatar !== null)
            <img class="image " src="{{ asset('/storage/' . auth('web')->user()->avatar) }}">
            @else
            <a class="" href="{{ route('users-avatar-add') }}">
                <img class="image " src="{{ asset('/storage/icon/images.png') }}">
            </a>
            @endif
            @if (auth('web')->user()->type === 'regular')
            <center class=" text-info font-italic"> {{ auth('web')->user()->name }} </center>
            <a href="{{ route('user-posts') }}" style="text-decoration: none">
                <center class=" text-info font-italic"> Posts: {{auth('web')->user()->posts->count()}} </center>
            </a>
            @else
            <center class=" text-info font-italic"> {{ auth('web')->user()->name }} </center>
            @endif

        </div>
    </div>
    <div class="split right ">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-2 mt-5">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h6 class="text-white">Add Post</h6>
                        </div>
                        <div class="card-body" style="background-color:rgb(243, 245, 215)">
                            <form method="post" action="{{ route('posts-store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                                </div>
                                @error('title')
                                <div class="alert alert-danger" role="alert">
                                    <a href="#" class="alert-link">{{ $message }}</a>
                                </div>
                                @enderror
                                <div class="form-group">
                                    <label><strong>Description :</strong></label>
                                    <input class="ckeditor form-control" name="description" value="{{ old('description') }}" />
                                </div>
                                @error('description')
                                <div class="alert alert-danger" role="alert">
                                    <a href="#" class="alert-link">{{ $message }}</a>
                                </div>
                                @enderror
                                <p>Status</p>
                                <div class="mb-3">
                                    @if (empty($posts) ? old('status') === 1 : old('status', $posts['status']) === 1)
                                    <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value=1 checked>
                                    <label class="btn btn-outline-success" for="success-outlined">Active</label>
                                    @else
                                    <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" value=1>
                                    <label class="btn btn-outline-success" for="success-outlined">Active</label>
                                    @endif
                                    @if (empty($posts) ? old('status') === 0 : old('status', $posts['status']) === 0)
                                    <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value=0 checked>
                                    <label class="btn btn-outline-danger" for="danger-outlined">Inactive</label>
                                    @else
                                    <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value=0>
                                    <label class="btn btn-outline-danger" for="danger-outlined">Inactive</label>
                                    @endif
                                    @error('status')
                                    <div class="alert alert-danger" role="alert">
                                        <a href="#" class="alert-link">{{ $message }}</a>
                                    </div>
                                    @enderror
                                </div>
                                <div class="">
                                    <label><strong>Select Category :</strong></label><br />
                                    <select class="selectpicker"  multiple data-live-search="true" name="categories[]">
                                        @foreach ($categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('categories')
                                <div class="alert alert-danger" role="alert">
                                    <a href="#" class="alert-link">{{ $message }}</a>
                                </div>
                                @enderror
                                <div class="text-center" style="margin-top: 10px;">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });

</script>

</html>
