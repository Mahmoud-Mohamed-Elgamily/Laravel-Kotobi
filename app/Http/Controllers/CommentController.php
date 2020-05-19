<?php

namespace App\Http\Controllers;

use App\Book;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = Book::findOrFail($request->book_id);
        if (empty($request->comment)){
            return response()->json(['error'=>'* Please Type a Comment ']);
        }
        else {
            $comment = $book->comments()->create([
                'comment_body' =>$request->comment ,
                'user_id'=>$request->user_id
            ]);
            $response = [
                'comment' => $comment,
                'date'=> date('d-m-Y g:ia', strtotime($comment->created_at)),
                'user'=> \Auth::user()
                
            ];
    
            return response()->json($response);
        }
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    { 
        $deletedRows = Comment::where(['id'=> $request->comment_id])->delete();
        $obj = [
            "status"=>$deletedRows
        ];
        return response()->json($obj);
    }  
}
