@component('mail::message')
# Information

Hi, {{$data->post->user->name}}

{{$data->liker->name}} liked your [post]({{config('app.url')}}/p/{{$data->post->id}})


Thanks,<br>
{{ config('app.name') }}
@endcomponent
