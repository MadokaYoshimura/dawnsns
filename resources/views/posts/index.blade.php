@extends('layouts.login')

@section('content')
{!! Form::open(['url' => '/top']) !!}
<div class="post-form">
  <div class="profile-img"><img src="{{ asset('images/icons/'.$user->images) }}"></div>
  {!! Form::textarea('newPost',null,['class' => 'input','placeholder' => '何をつぶやこうか…？']) !!}

  <div class="post-btn">
    @if($errors->any())
    <ul class="error-message">
      @foreach($errors->get('newPost') as $newPost)
      <li>{{ $newPost }}</li>
      @endforeach
    </ul>
    @endif
    <button type="submit"><img src="images/post.png" alt="投稿ボタン"></button>
  </div>
</div>
{!! Form::close() !!}

<div id="post">
  @foreach($list as $list)
  <div class="post-wrapper">
    <div class="post-list">
      <div class="profile-img"><a href="/profile/{{ $list->user_id }}"><img src="{{ asset('images/icons/'.$list->images) }}" alt="アイコン"></a></div>
      <div class="post-item">
        <div class="post-user">
          <div>{{ $list->username }}</div>
          <div>{{ $list->created_at }}</div>
        </div>
        <div class="post-content">
          <div>{{ $list->posts }}</div>
        </div>
      </div>
    </div>

    {{-- 自分の投稿のみ編集と削除が可能 --}}
    @if($list->user_id === Auth::id())
    <div class="post-edit">
      {{-- 編集ボタン --}}
      <button class="edit-btn" data-target="edit-post{{ $list->id }}">
        <img src="images/edit.png" alt="">
      </button>

      {{-- 削除ボタン --}}
      <button class="delete-btn" data-target="delete-post{{ $list->id }}"></button>
    </div>
    @endif
  </div>
  {{-- 編集モーダル --}}
  <div class="edit-modal" id="edit-post{{ $list->id }}">
    <div class="modal-inner">
      <div class="modal-overlay">
        <div class="modal-content">
          {!! Form::open(['url' => '/post/update','method'=> 'post','name'=> 'edit']) !!}
          {!! Form::hidden('id', $list->id) !!}
          {!! Form::textarea('upPost', $list->posts, ['required','class'=>'post-length']) !!}

          <p class="length-error"></p>

          <div class="btn edit-btn">
            <button class="edit-submit edit-btn" type="submit"><img src="images/edit.png" alt=""></button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>

  {{-- 削除確認モーダル --}}
  <div class="delete-modal" id="delete-post{{ $list->id }}">
    <p>このつぶやきを削除します。よろしいでしょうか？</p>
    <div class="modal-btn">
      <a href="/post/{{ $list->id }}/delete" class="modal-execution">OK</a>
      <a href="" class="modal-close">キャンセル</a>
    </div>
  </div>
  @endforeach
</div>


@endsection
