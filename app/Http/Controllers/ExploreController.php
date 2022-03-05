<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExploreController extends Controller
{
  public function index()
  {
    if (auth()->user()) {
      // $userId = auth()->user()->id;
      $followedUsers = auth()->user()->following()->pluck('profiles.user_id');
      $posts = DB::select("SELECT * FROM posts 
      WHERE user_id NOT IN {$followedUsers}");
      return view('explore.index', compact('posts'));
    }
  }
}
