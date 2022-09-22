@extends('layouts.login')

@section('content')
<h2 class="list-title">Follower List</h2>
<ul class="follows-list">
  @foreach($follower_list as $follower_list)
  <li class="profile-img"><a href="profile/{{ $follower_list->id }}"><img src="images/icons/{{ $follower_list->images }}" alt="アイコン"></a></li>
  @endforeach
</ul>

<div id="post">
  @foreach($follower_posts as $follower_posts)
  <div class="post-wrapper">
    <div class="post-list">
      <div class="profile-img"><a href="/profile/{{ $follower_posts->user_id }}"><img src="images/icons/{{ $follower_posts->images }}" alt="アイコン"></a></div>
      <div class="post-item">
        <div class="post-user">
          <div>{{ $follower_posts->username }}</div>
          <div>{{ $follower_posts->created_at }}</div>
        </div>
        <div class="post-content">
          <div>{{$follower_posts->posts }}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection
