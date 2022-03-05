<?php

namespace App\Models;

use App\Mail\NewUserWelcomeMail;
use App\Http\Controllers\MailController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'username',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public static function boot()
  {
    parent::boot();
    static::created(function ($user) {
      $user->profile()->create([
        'title' => $user->username
      ]);

      // Mail::to($user->email)->send(new NewUserWelcomeMail());
      $data = ['name' => $user->name];
      Mail::send('emails.welcome-email', $data, function ($message) use($user) {
        $message->to($user->email, $user->name)->subject('Laravel HTML Testing Mail');
        $message->from('jeazzt12@gmail.com', 'Jess');
      });
    });
  }

  public function profile()
  {
    return $this->hasOne(Profile::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
  }

  public function following()
  {
    return $this->belongsToMany(Profile::class);
  }

  public function likesToPosts() {
    return $this->belongsToMany(Post::class, 'user_like');
  }

  public function commentsToPosts() {
    return $this->belongsToMany(Post::class, 'user_comment');
  }

  public function getTotalPostLike(User $user) {
    $postIds = Post::where('user_id', $user->id)->get()->toArray();
    $total = $this->belongsToMany(Post::class, 'user_like')->wherePivotIn('post_id', $postIds)->get()->count();
    return $total;
  }
}
