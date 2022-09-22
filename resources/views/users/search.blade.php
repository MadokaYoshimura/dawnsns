@extends('layouts.login')

@section('content')

{!! Form::open(['url' => '/search','method'=>'get']) !!}

<div class="search-form">
  {!! Form::text('Search',null,['class' => 'input','placeholder' => 'ユーザー名']) !!}
  <button class="search-btn" type="submit">検索</button>
  <p class="search-word">検索ワード：{{ $search }}</p>
</div>
{!! Form::close() !!}

<div class="search-result">
  @foreach($list as $list)
  <div class="user-wrapper">
    <div class="user-list">
      <div class="profile-img">
        <a href="/profile/{{ $list->id }}">
          <img src="{{ asset('images/icons/'.$list->images) }}" alt="アイコン">
        </a>
      </div>
      <div class="user-name">{{ $list->username }}</div>
      <!-- ユーザーのidが$followedと一致しない場合 -->
      @if(!in_array($list->id, $followed))
      {{-- $follow->contains('follow_id', $list->id) --}}
      <div class="follows-btn">
        <a href="/follow/{{ $list->id }}">フォローする</a>
      </div>
      <!-- 逆の場合 -->
      @else
      <div class="follows-btn remove">
        <a href="/remove/{{ $list->id }}">フォローをはずす</a>
      </div>
      @endif
    </div>
  </div>
  @endforeach
</div>


@endsection
