<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
  public function index(User $user)
  {
    $followed = (auth()->user()) ? auth()->user()->following->contains($user->profile->id) : false;
    $postsCount = Cache::remember(
      'count.posts' . $user->id,
      now()->addSeconds(30),
      function () use ($user) {
        return $user->posts->count();
      }
    );
    $followersCount = Cache::remember(
      'count.followers' . $user->id,
      now()->addSeconds(30),
      function () use ($user) {
        return $user->profile->followers->count();
      }
    );
    $followingsCount = Cache::remember(
      'count.followings' . $user->id,
      now()->addSeconds(30),
      function () use ($user) {
        return $user->following->count();
      }
    );

    return view('profile.index', compact('user', 'followed', 'postsCount', 'followersCount', 'followingsCount'));
  }

  function edit(User $user)
  {
    $this->authorize('update', $user->profile);
    return view('profile.edit', compact('user'));
  }

  function update(User $user)
  {
    $this->authorize('update', $user->profile);
    $data = request()->validate([
      'title' => 'required',
      'description' => '',
      'url' => 'url',
      'image' => ''
    ]);

    if (request('image')) {
      $imagePath = request('image')->store('profile', 'public');
      $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1000, 1000);
      $image->save();
    }

    auth()->user()->profile->update(array_merge(
      $data,
      ['image' => $imagePath]
    ));
    return redirect("/profile/{$user->id}");
  }
}
