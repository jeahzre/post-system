@extends('layouts.app')

@section('content')
  <div class="container">
    <form action="/profile/{{ $user->id }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="row mb-3">
        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

        <div class="col-md-6">
          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
            autocomplete="on" autofocus value="{{ old('title') ?? $user->profile->title }}">

          @error('title')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

        <div class="col-md-6">
          <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
            name="description" autocomplete="on" autofocus
            value="{{ old('description') ?? $user->profile->description }}">

          @error('description')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="url" class="col-md-4 col-form-label text-md-end">{{ __('URL') }}</label>

        <div class="col-md-6">
          <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" autocomplete="on"
            autofocus value="{{ old('url') ?? $user->profile->url }}">

          @error('url')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

        <div class="col-md-6">
          <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image"
            autocomplete="on" autofocus>

          @error('image')
            jj
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
          <button class="btn-primary" type="submit">Save Profile</button>
        </div>
      </div>
    </form>
  </div>
@endsection
