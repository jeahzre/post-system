@extends('layouts.app')

@section('content')
  <div class="container">
     @foreach ($posts as $post)
         <div>{{$post->user_id}}</div>
     @endforeach
  </div>
@endsection
