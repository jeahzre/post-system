<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;

class PostController extends Controller
{
  public function index()
  {
    if (auth()->user()) {
      // $liked = auth()->user()->likesToPost()->contains();
      $users = auth()->user()->following()->pluck('profiles.user_id')->toArray();
      $users[] = auth()->user()->id;
      $posts = Post::whereIn('user_id', $users)->with(['user', 'likers', 'commenters'])->latest()->paginate(5);
      // $posts->commenters->pivot->createdAt->diffForHuman();
      // $liked = $post->likers->contains(auth()->user()->id);
      // $commented = $post->commenters->contains(auth()->user()->id);
      return view('posts.index', compact('posts'));
    } else {
      $posts = Post::with(['user', 'likers', 'commenters'])->latest()->paginate(5);
      return view('posts.index', compact('posts'));
    }
  }

  public function create()
  {
    return view('posts.create');
  }

  public function store()
  {
    $data = request()->validate([
      'caption' => 'required',
      'image' => ['required', 'image']
    ]);
    $imagePath = request('image')->store('uploads', 'public');
    $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1200, 1200);
    $image->save();
    auth()->user()->posts()->create([
      'caption' => $data['caption'],
      'image' => $imagePath
    ]);

    return redirect('/profile/' . auth()->user()->id);
  }

  function show(Post $post)
  {
    $postId = $post->id;
    $post = Post::where('id', $postId)->with(['user', 'likers', 'commenters'])->get()->first();
    return view('posts.show', compact('post'));
  }

  function destroy(Post $post)
  {
    $this->authorize('delete', $post);
    $post->delete();
    return response()->json('deleted');
  }
}
