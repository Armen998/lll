@extends('Web/layout')

@section('content')

    @include('Web/repeatitions.create-edit', ['posts' => $posts])
@endsection
