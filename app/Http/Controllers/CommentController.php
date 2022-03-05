<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class CommentController extends Controller
{
  public function store(Post $post) {
    $data = request()->validate([
      'comment' => 'required'
    ]);

    $userId = auth()->user()->id;
    $postId = $post->id;
    $user_comment_id = DB::table('user_comment')->insertGetId([ 
      'user_id' => $userId, 
      'post_id' => $postId, 
      'comment' => $data['comment'], 
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);
    $user_comment = DB::table('user_comment')->where('id', '=', $user_comment_id)->get()->first();
    $user = DB::table('users')->where('id', '=', $userId)->get()->first();
    $result = (object)array(
      'user' => $user, 
      'user_comment' => $user_comment
    );
    return $result;
  }
}
