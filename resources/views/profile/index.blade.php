@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="d-flex mb-5 justify-content-around align-items-center" alt="profile ptify-content-center">
        <div class="col-3">
          <img class="w-50 rounded-circle" src="{{ $user->profile->profileImage() }}">
        </div>
        <div class="col-6 d-flex flex-column justify-content-between align-items-center">
          <div>
            {{ $postsCount }} posts
          </div>
          <div>
            {{ $followersCount }}
            followers
          </div>
          <div>
            {{ $followingsCount }}
            following
          </div>
          {{$user->getTotalPostLike($user)}} likes in posts by another users
        </div>
        @can('follow', $user->profile)
          <div data-user-id="{{ $user->id }}" data-followed="{{ json_encode($followed) }}" id="follow-button"></div>
        @endcan
      </div>
      <strong>{{ $user->profile->title }}</strong>
      <div>{{ $user->profile->description }}</div>
      <a class="mb-3" href="{{ $user->profile->url }}">{{ $user->profile->url }}</a>

      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <div class="d-flex justify-content-end mb-5">
        @can('update', $user->profile)
          <button class="btn-primary w-25" onclick="window.location = '/p/create'">
            Add new post
          </button>
        @endcan

        @can('update', $user->profile)
          <button class="btn-primary w-25" onclick="window.location = '/profile/{{ $user->id }}/edit'">
            Edit profile
          </button>
        @endcan
      </div>

    </div>
    <div class="row">
      @if ($user->posts->count())
        @foreach ($user->posts as $post)
          <a class="w-25 col-3 offset-1" href="/p/{{ $post->id }}">
            <img src="/storage/{{ $post->image }}" class="w-100 pb-4">
          </a>
        @endforeach
      @else
        <div class="text-center">No posts</div>
      @endif
    </div>
  </div>
@endsection
