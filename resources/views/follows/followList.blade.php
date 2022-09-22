@extends('layouts.login')

@section('content')
<h2 class="list-title">Follow List</h2>
<ul class="follows-list">
  @foreach($follow_list as $follow_list)
  <li class="profile-img">
    <a href="profile/{{ $follow_list->id }}">
      <img src="images/icons/{{ $follow_list->images }}" alt="アイコン">
    </a>
  </li>
  @endforeach
</ul>

<div id="post">
  @foreach($follow_posts as $follow_posts)
  <div class="post-wrapper">
    <div class="post-list">
      <div class="profile-img">
        <a href="/profile/{{ $follow_posts->user_id }}">
          <img src="images/icons/{{ $follow_posts->images }}" alt="アイコン">
        </a>
      </div>
      <div class="post-item">
        <div class="post-user">
          <div>{{ $follow_posts->username }}</div>
          <div>{{ $follow_posts->created_at }}</div>
        </div>
        <div class="post-content">
          <div>{{$follow_posts->posts }}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection
