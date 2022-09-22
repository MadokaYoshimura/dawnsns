<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
// ログイン画面
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@login');

// 新規会員登録画面
Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

// 登録後の画面
Route::get('/added', 'Auth\RegisterController@added');



//ログイン中のページ
Route::group(['middleware' => 'auth'], function () {
  // トップページの表示
  Route::get('/top', 'PostsController@index');
  // つぶやきの投稿機能
  Route::post('/top', 'PostsController@create');

  // 投稿の編集
  // Route::get('/post/{id}/post-update', 'PostsController@postUpdateForm')->name('post-update');
  Route::post('/post/update', 'PostsController@postUpdate');

  // 投稿の削除
  Route::get('/post/{id}/delete', 'PostsController@delete');

  // プロフィールの表示
  Route::get('/profile/{id}', 'UsersController@profile')->name('profile');
  // プロフィールの編集
  Route::get('/profile/{id}/profile-update', 'UsersController@profileUpdateForm')->name('profile-update');
  Route::post('/profile/update', 'UsersController@profileUpdate');

  // フォロー・リムーブ機能
  Route::get('/follow/{id}', 'FollowsController@follow');
  Route::get('/remove/{id}', 'FollowsController@remove');

  // 検索機能
  Route::get('/search', 'UsersController@search');

  // フォロー・フォロワーリストの表示
  Route::get('/follow-list', 'FollowsController@followList');
  Route::get('/follower-list', 'FollowsController@followerList');

  // ログアウト機能
  Route::get('/logout', 'Auth\LoginController@logout');
});
