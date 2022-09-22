@extends('layouts.logout')

@section('content')


<div class="form-outer">
  {!! Form::open(['url' => '/login','method' => 'post']) !!}

  <h2>DAWNのSNSへようこそ</h2>
  <div class="form-inner">
    <div class="form-item">
      <div class="form-label">
        {{ Form::label('mail','MailAdress') }}
      </div>
      <div class="form-input">
        {{ Form::email('mail',old('mail'),['class' => 'input']) }}
      </div>
    </div>

    <div class="form-item">
      <div class="form-label">
        {{ Form::label('password','Password') }}
      </div>
      <div class="form-input">
        {{ Form::password('password',['class' => 'input']) }}
      </div>
    </div>

    @if($errors->any())
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
    @endif
    <ul>
      @if(session('error'))
      <li>{{ session('error') }}</li>
      @endif
    </ul>

    <div class="form-btn">
      {{ Form::submit('LOGIN') }}
    </div>
  </div>

  <p><a href="/register">新規ユーザーの方はこちら</a></p>

  {!! Form::close() !!}
</div>

@endsection
