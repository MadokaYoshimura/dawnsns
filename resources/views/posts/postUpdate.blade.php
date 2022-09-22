@extends('layouts.login')

@section('content')

{!! Form::open(['url' => '/post/update','method'=> 'post']) !!}
{!! Form::hidden('id', $post->id) !!}
{!! Form::textarea('upPost', $post->posts, ['required']) !!}

@if($errors->any())
<ul class="error-message">
  @foreach($errors->get('upPost') as $upPost)
  <li>{{ $upPost }}</li>
  @endforeach
</ul>
@endif

<button type="submit" onclick="return confirm('内容を変更してよろしいですか？')">更新</button>
{!! Form::close() !!}

@endsection
