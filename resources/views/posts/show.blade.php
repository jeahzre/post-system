@extends('layouts.app')

@section('content')
  {{-- <div class="container">
    <div class="d-flex align-items-center bg-dark p-1">
      <a href="/profile/{{ $post->user_id }}" class="col-2 me-3 d-flex justify-content-center">
        <img class="w-50 rounded-circle  p-3" src="{{ $post->user->profile->profileImage() }}" alt="profile picture">
      </a>
      <a href="/profile/{{ $post->user_id }}" class="text-decoration-none">
        <strong class="fs-4">
          {{ $post->user->username }}
        </strong>
      </a>
    </div>
    <div class="row">
      <img class="w-100" src="/storage/{{ $post->image }}" alt="image">
    </div>
    <div class="bg-dark p-3">
      <a class="text-decoration-none" href="/profile/{{ $post->user_id }}">
        <strong>
          {{ $post->user->username }}
        </strong>
      </a>
      <p>
        {{ $post->caption }}
      </p>
      <i>{{ $post->created_at }}</i>
    </div>
  </div> --}}
  <div class="container w-90">
    <div data-post-id={{ $post->id }} data-post={{ preg_replace('/\s+/', '\u0020', $post) }} {{-- data-post={{$post}} --}}
      data-user={{ auth()->user() ? auth()->user() : 'null' }}
      data-post-user-profile-image={{ json_encode($post->user->profile->profileImage()) }}
      data-like-count={{ $post->likers->count() }} data-liked={{ json_encode($post->likedBy($post, auth()->user())) }}
      data-comment-count={{ $post->commenters->count() }}
      data-commented={{ json_encode($post->commentedBy($post, auth()->user())) }} class="pb-5"
      data-is-show-one="true"
      react-component="Post">
    </div>
  </div>
@endsection
