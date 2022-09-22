@extends('layouts.login')

@section('content')

<div class="profile-content">
  <div class="profile-img">
    <img src="{{ asset('images/icons/'.$select_user->images) }}" alt="アイコン">
  </div>
  <ul class="profile-detail">
    <div class="profile-item">
      <li>Name</li>
      <li>{{ $select_user->username }}</li>
    </div>
    <div class="profile-item">
      <li>Bio</li>
      <li>{{ $select_user->bio }}</li>
    </div>
  </ul>
  <!-- ユーザーのidが$followedと一致しなかった場合（未フォロー） -->
  @if($select_user->id === Auth::id())
  <div class="follows-btn"></div>
  @elseif(!in_array($select_user->id, $followed))
  <div class="follows-btn">
    <a href="/follow/{{ $select_user->id }}">フォローする</a>
  </div>
  <!-- 逆の場合 -->
  @else
  <div class="follows-btn remove">
    <a href="/remove/{{ $select_user->id }}">フォローをはずす</a>
  </div>
  @endif
</div>

<div id="post">
  @foreach($profile_list as $profile_list)
  <div class="post-wrapper">
    <div class="post-list">
      <div class="profile-img"><a href="/profile/{{ $select_user->id }}"><img src="{{ asset('images/icons/'.$profile_list->images) }}" alt="アイコン"></a></div>
      <div class="post-item">
        <div class="post-user">
          <div>{{$profile_list->username }}</div>
          <div>{{ $profile_list->created_at }}</div>
        </div>
        <div class="post-content">
          <div>{{ $profile_list->posts }}</div>
        </div>
      </div>
    </div>

    {{-- 自分の投稿のみ編集と削除が可能 --}}
    @if($select_user->id === Auth::id())
    <div class="post-edit">
      <button class="edit-btn" data-target="edit-post{{ $profile_list->id }}">
        <img src="/images/edit.png" alt="">
      </button>
      {{-- 削除ボタン --}}
      <button class="delete-btn" data-target="delete-post{{ $profile_list->id }}"></button>
    </div>
    @endif
  </div>

  {{-- 編集モーダル --}}
  <div class="edit-modal" id="edit-post{{ $profile_list->id }}">
    <div class="modal-inner">
      <div class="modal-content">
        {!! Form::open(['url' => '/post/update','method'=> 'post','name'=> 'edit']) !!}
        {!! Form::hidden('id', $profile_list->id) !!}
        {!! Form::textarea('upPost', $profile_list->posts, ['required','class'=>'post-length']) !!}

        <p class="length-error"></p>

        <div class="btn edit-btn">
          <button class="edit-submit edit-btn" type="submit"><img src="/images/edit.png" alt=""></button>
        </div> {!! Form::close() !!}
      </div>
    </div>

  </div>{{-- 削除確認モーダル --}}
  <div class="delete-modal" id="delete-post{{ $profile_list->id }}">
    <p>このつぶやきを削除します。よろしいでしょうか？</p>
    <div class="modal-btn">
      <a href="/post/{{ $profile_list->id }}/delete" class="modal-execution">OK</a>
      <a href="" class="modal-close">キャンセル</a>
    </div>
  </div>
  @endforeach
</div>

@endsection
