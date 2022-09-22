@extends('layouts.logout')

@section('content')

<div id="clear">
  <div class="form-outer">
    <h2 class="user-name">{{ $user->username }}さん</h2>
    <h2>ようこそ！DAWNSNSへ</h2>
    <div class="add-message">
      <p>ユーザー登録が完了しました。</p>
      <p>さっそく、ログインをしてみましょう</p>
    </div>

    <p class="btn"><a href="/login">ログイン画面へ</a></p>
  </div>
</div>

@endsection
