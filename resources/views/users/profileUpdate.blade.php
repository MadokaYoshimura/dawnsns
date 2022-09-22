@extends('layouts.login')

@section('content')

<div id="profileEdit">
  <div class="profile-img"><img src="/images/icons/{{ Auth::user()->images }}" alt="アイコン">
  </div>
  <div class="profileEdit-wrapper">
    {!! Form::open(['url' => '/profile/update','method'=> 'post','enctype'=>'multipart/form-data']) !!}
    <ul class="profile-list">
      <li>
        {{ Form::label('username','UserName') }}
      </li>
      <li>
        {!! Form::text('username', $user->username, ['required']) !!}
      </li>
    </ul>
    <ul class="profile-list">
      <li>
        {{ Form::label('mail','MailAdress') }}
      </li>
      <li>
        {!! Form::email('mail', $user->mail, ['required']) !!}
      </li>
    </ul>
    <ul class="profile-list">
      <li>
        {{ Form::label('password','Password') }}
      </li>
      <li>
        {!! Form::text('password',Str_repeat::limit('●●●●●●●●●●●●',$word_count,'' ),['readonly']) !!}
      </li>
    </ul>
    <ul class="profile-list">
      <li>
        {{ Form::label('new_password','New&nbsp;Password') }}
      </li>
      <li>
        {!! Form::password('new_password') !!}
      </li>
    </ul>
    <ul class="profile-list">
      <li>
        {{ Form::label('bio','Bio') }}
      </li>
      <li>
        {!! Form::textarea('bio', $user->bio) !!}
      </li>
    </ul>
    <ul class="profile-list file">
      <li>
        Icon&nbsp;Image
      </li>
      <li>
        {{ Form::label('images','ファイルを選択') }}
        {!! Form::file('images',['class' => 'file_name']) !!}
        <span id="fileName"></span>
      </li>
    </ul>
    @if($errors->any())
    <ul class="error-message">
      @foreach($errors->get('username') as $username)
      <li>{{ $username }}</li>
      @endforeach

      @foreach($errors->get('mail') as $mail)
      <li>{{ $mail }}</li>
      @endforeach

      @foreach($errors->get('new_password') as $password)
      <li>{{ $password }}</li>
      @endforeach

      @foreach($errors->get('bio') as $bio)
      <li>{{ $bio }}</li>
      @endforeach

      @foreach($errors->get('images') as $images)
      <li>{{ $images }}</li>
      @endforeach
    </ul>
    @endif
  </div>
</div>
<div class="profile-btn">
  <button type="submit" onclick="return confirm('この内容で保存しますか？')">更新</button>
</div>
{!! Form::close() !!}

@endsection
