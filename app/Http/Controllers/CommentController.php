<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments, 200);
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
            return response()->json($comment, 200);
        }
    }

    public function show(Post $post, $id)
    {
        $comment = Comment::find($id);
        if($comment){
            return response()->json($comment, 200);
        }else{
            return response()->json(['error' => "The comment you are looking for doesn't exists.",
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
                Comment::where('id',$id) -> update(
                    ['content' => $request['content'],
                    'author' => $request['author']
                    ]);
                $comment = Comment::find($id);
                return response()->json($post, 200);
            }
        }else{
            return response()->json(['error' => "The comment you wanted to update doesn't exists.",
                                      'code' => 404], 404);
        }
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if($comment){
            Comment::destroy($id);
            return response()->json("The comment with the id '".$id."' has been deleted succesfully.", 200);
        }else{
            return response()->json(['error' => "The comment you wanted to delete doesn't exists.",
                                      'code' => 404], 404);
        }
    }
}
