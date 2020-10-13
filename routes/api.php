<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('posts', 'PostController');
Route::apiResource('posts.comments', 'CommentController');