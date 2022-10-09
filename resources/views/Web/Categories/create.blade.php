@extends('Web.layout')

@section('content')

<div class="d-flex container">
    @if (session()->has('indication'))
    <div class="alert alert-danger" role="alert"> {{ session()->get('indication') }} </div>
    @endif
    <form method="POST" action="{{ route('categories-store') }}">
        @csrf
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Category Title</label>
            <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('title')}}">
            @error('title')
            <div class="alert alert-danger" role="alert">
                <a href="#" class="alert-link">{{ $message }}</a>
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
