@extends('layouts.app')

@section('content')
  <div class="container">
    <form action="/p" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row mb-3">
        <label for="caption" class="col-md-4 col-form-label text-md-end">{{ __('Caption') }}</label>

        <div class="col-md-6">
          <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption"
            autocomplete="on" autofocus>

          @error('caption')
            <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
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
            <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
          <button class="btn-primary" type="submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
@endsection
