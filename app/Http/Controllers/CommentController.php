<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function all()
    {
        $comments = Comment::all();
        return response()->json($comments, 200);
    }

    public function allPC()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $post['comments'] = $post->comments;
            $PC[] = $post;
        }
        return response()->json($PC, 200);
    }

    public function allFromPost(Post $post)
    {
        $comments = Post::find($post['id'])->comments;
        if($post==null){
            return response()->json(['message' => "The post you are looking for doesn't exists.",
                                      'code' => 404], 404);
        }
        if(count($comments)){
            return response()->json($comments, 200);
        }else{
            return response()->json(['message' => "This post doesn't have any comments.",
                                      'code' => 200], 200);
        }
    }

    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(),[
            'author' => 'required|min:1|max:30',
            'content' => 'required|min:1|max:255'
        ]);
        $errors = $validator->errors();
        
        if($validator->fails()){
            return response()->json($errors, 400);
        }else{
            $comment = Comment::create(
                ['post' => $post['id'],
                'content' => $request['content'],
                'author' => $request['author']
                ]);
            return response()->json($comment, 201);
        }
    }

    public function show(Post $post, $id)
    {
        $comment = Comment::find($id);
        if($comment){
            return response()->json($comment, 200);
        }else{
            return response()->json(['message' => "The comment you are looking for doesn't exists.",
                                      'code' => 404], 404);
        }
    }   

    public function update(Request $request, Post $post, $id)
    {
        if(Comment::find($id)){
            $validator = Validator::make($request->all(), [
                'author' => 'required|min:1|max:30',
                'content' => 'required|min:1|max:255'
            ]);
            $errors = $validator->errors();
            
            if($validator->fails()){
                return response()->json($errors, 400);
            }else{
                Comment::find($id) -> update(
                    ['content' => $request['content'],
                    'author' => $request['author']
                    ]);
                $comment = Comment::find($id);
                return response()->json($comment, 201);
            }
        }else{
            return response()->json(['message' => "The comment you wanted to update doesn't exists.",
                                      'code' => 400], 400);
        }
    }

    public function destroyAll()
    {
        Comment::all()->delete();
        return response()->json(['message' => "All the comments have been deleted succesfully.", 'code' => 200], 200);
    }

    public function destroyFromPost(Post $post)
    {
        return response()->json(['message' => "All the comments have been deleted succesfully.", 'code' => 200], 200);
        $comments = Post::find($post)->comments->delete();
        if($comments){
            return response()->json(['message' => "All the comments from the post '".$post['id']."' have been deleted succesfully.", 
                                        'code' => 200], 200);
        }else{
            return response()->json(['error' => "The post you are looking for doesn't exists.",
                                      'code' => 400], 400);
        }
    }

    public function destroy(Post $post, $id)
    {
        $comment = Comment::find($id);
        if($comment){
            Comment::destroy($id);
            return response()->json("The comment with the id '".$id."' has been deleted succesfully.", 200);
        }else{
            return response()->json(['message' => "The comment you wanted to delete doesn't exists.",
                                      'code' => 400], 400);
        }
    }
    
    
}
