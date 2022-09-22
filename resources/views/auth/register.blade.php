@extends('layouts.logout')

@section('content')

<div class="form-outer">
  {!! Form::open(['url' => '/register','method'=> 'post']) !!}

  <h2>新規ユーザー登録</h2>
  <div class="form-inner">
    <div class="alert alert-danger form-item">
      <div class="form-label">
        {{ Form::label('username','UserName') }}
      </div>
      <div class="form-input">
        {{ Form::text('username',old('username'),['class' => 'input','placeholder'=>'dawntown']) }}
      </div>
    </div>

    <div class="alert alert-danger form-item">
      <div class="form-label">
        {{ Form::label('mail','MailAdress') }}
      </div>
      <div class="form-input">
        {{ Form::email('mail',old('mail'),['class' => 'input','placeholder'=>'dawn@dawn.jp']) }}
      </div>
    </div>

    <div class="alert alert-danger form-item">
      <div class="form-label">
        {{ Form::label('password','Password') }}
      </div>
      <div class="form-input">
        {{ Form::password('password',null,['class' => 'input']) }}
      </div>
    </div>

    <div class="alert alert-danger form-item">
      <div class="form-label">
        {{ Form::label('password_confirmation','Password confirm') }}
      </div>
      <div class="form-input">
        {{ Form::password('password_confirmation',null,['class' => 'input']) }}
      </div>
    </div>

    @if ($errors->any())
    <ul class="error-message">
      @foreach($errors->get('username') as $username)
      <li>{{ $username }}</li>
      @endforeach
    </ul>
    <ul class="error-message">
      @foreach($errors->get('mail') as $mail)
      <li>{{ $mail }}</li>
      @endforeach
    </ul>
    <ul class="error-message">
      @foreach($errors->get('password') as $password)
      <li>{{ $password }}</li>
      @endforeach
    </ul>
    <ul class="error-message">
      @foreach($errors->get('password_confirmation') as $password_confirmation)
      <li>{{ $password_confirmation }}</li>
      @endforeach
    </ul>
    @endif

    <div class="form-btn">
      {{ Form::submit('REGISTER') }}
    </div>
  </div>

  <p><a href="/login">ログイン画面へ戻る</a></p>

  {!! Form::close() !!}
</div>

@endsection
