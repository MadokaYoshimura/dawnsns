<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>

<body>
    <header>
        <div id="head">
            <h1><a href="/top"><img src="/images/main_logo.png"></a></h1>
            <div id="head-inner">
                <div id="head-content">
                    <p>{{ $user->username }}&nbsp;さん<span class="ac-btn"></span>
                        <div class="head-img"><img src="{{ asset('images/icons/'.$user->images) }}"></div>
                    </p>
                </div>
            </div>
    </header>
    <ul class="ac-menu close">
        <li><a href="/top">HOME</a></li>
        <li><a href="/profile/{{ Auth::id() }}/profile-update">プロフィール編集</a></li>
        <li><a href="/logout">ログアウト</a></li>
    </ul>
    <div id="row">
        <div id="container">
            @yield('content')
        </div>
        <div id="side-bar">
            <div id="confirm">
                <p>{{ $user->username }}さんの</p>
                <div class="side-follows">
                    <p>フォロー数</p>
                    <p>{{ $follow_count }}&nbsp;名</p>
                </div>
                <div class="btn"><a href="/follow-list">フォローリスト</a></div>
                <div class="side-follows">
                    <p>フォロワー数</p>
                    <p>{{ $follower_count }}&nbsp;名</p>
                </div>
                <div class="btn"><a href="/follower-list">フォロワーリスト</a></div>
            </div>
            <div class="btn user-search"><a href="/search">ユーザー検索</a></div>
        </div>
    </div>

    <footer>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/script.js"></script>
</body>

</html>
