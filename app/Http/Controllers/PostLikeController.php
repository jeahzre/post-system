<?php

namespace App\Http\Controllers;

use App\Mail\PostLikedMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
  public function store(Post $post)
  {
    $userId = auth()->user()->id;
    $data = (object)[
      'liker' => auth()->user(),
      'post' => $post
    ];
    $receiver = $post->user;

    $mailData = new \stdClass();
    $mailData->from = 'jeazzt12@gmail.com';
    $mailData->name = 'Jess';
    $mailData->subject = 'Someone liked your post';
    $mailData->data = $data;
    Mail::to($receiver->email)->send(new PostLikedMail($mailData));
    // ::send('emails.post.post_liked', $data, function ($message) use($receiver) {
    //   $message->to($receiver->email, $receiver->name)->subject('Someone liked your post');
    //   $message->from('jeazzt12@gmail.com', 'Jess');
    // });
    return $post->likers()->toggle($userId);
  }
}
