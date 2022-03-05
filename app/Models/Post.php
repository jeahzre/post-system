<?php

namespace App\Models;

use App\Models\CustomPivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'created_at' => 'datetime:Y-m-d',
    'updated_at' => 'datetime:Y-m-d'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function profile()
  {
    return $this->belongsTo(Profile::class);
  }

  public function likedBy(Post $post, User $user = null)
  {
    if ($user) {
      return $post->likers->contains($user->id);
    } else {
      return false;
    }
  }

  public function likers()
  {
    return $this->belongsToMany(User::class, 'user_like')->withTimestamps();
  }

  public function commentedBy(Post $post, User $user = null)
  {
    if ($user) {
        return $post->commenters->contains($user->id);
    } else {
      return false;
    }
  }

  public function commenters()
  {
    return $this->belongsToMany(User::class, 'user_comment')->withTimestamps()->withPivot('id', 'comment')
      ->using(CustomPivot::class);
  }
}
