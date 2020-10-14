<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::apiResource('posts', 'PostController');
//Route::apiResource('posts.comments', 'CommentController');

//General
Route::get('/posts/comments','CommentController@allPC');


//Posts
Route::get('/posts','PostController@all');
Route::get('/posts/{post}','PostController@show');

Route::post('/posts','PostController@store');

Route::put('/posts/{post}','PostController@update');

Route::delete('/posts','CommentController@destroyAll');
Route::delete('/posts/{post}','PostController@destroy');

//Comments
Route::get('/comments','CommentController@all');
Route::get('/comments/{comment}','CommentController@show'); 
Route::get('/posts/{post}/comments','CommentController@allFromPost');
Route::get('/posts/{post}/comments/{comment}','CommentController@show');

Route::post('/posts/{post}/comments','CommentController@store');

Route::put('/posts/{post}/comments/{comment}','CommentController@update');

Route::delete('/comments','CommentController@destroyAll');
Route::delete('/posts/{post}/comments','CommentController@destroyFromPost');
Route::delete('/posts/{post}/comments/{comment}','CommentController@destroy');

