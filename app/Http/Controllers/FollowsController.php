<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
  public function store(User $user)
  {
    $this->authorize('follow', $user->profile);
    return auth()->user()->following()->toggle($user->profile);
  }
}
