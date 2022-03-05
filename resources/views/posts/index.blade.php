@extends('layouts.app')

@section('content')
  <div class="container w-90">
    @if ($posts->count())
      @foreach ($posts as $post)
        <div data-post-id={{ $post->id }} data-post={{ preg_replace('/\s+/', '\u0020', $post) }}
          data-user={{ auth()->user() ? auth()->user() : 'null' }}
          data-post-user-profile-image={{ json_encode($post->user->profile->profileImage()) }}
          data-like-count={{ $post->likers->count() }}
          data-liked={{ json_encode($post->likedBy($post, auth()->user())) }}
          data-comment-count={{ $post->commenters->count() }}
          data-commented={{ json_encode($post->commentedBy($post, auth()->user())) }} {{-- Is show only one post on page --}}
          data-is-show-one="false" @can('delete', $post) data-can-delete="true" @endcan class="pb-5"
          react-component="Post">
        </div>
      @endforeach

      <div class="row">
        <div class="col-12 d-flex justify-content-end">
          {{ $posts->links() }}
        </div>
      </div>
    @else
      <div class="text-center">No posts</div>
    @endif
  </div>
  {{-- <form action="{{route('like')}}">

  </form> --}}
@endsection
