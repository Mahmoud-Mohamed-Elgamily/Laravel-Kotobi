<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Favourite;
use Illuminate\Http\Request;
use Auth;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $book = new Book();
        $categories = Category::all();
        return view('books.create', compact('book','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $book = Book::create($this->validateRequest($request));
        $this->storeImage($book);
        return redirect('book')->with('message','a new book has been added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $is_favourite = Favourite::where(['user_id'=>Auth::id(),'book_id'=>$id])->get()->count();
        return view('books.show', ['book' => Book::findOrFail($id),'is_favourite'=>$is_favourite]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit',compact('book','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->update($this->validateRequest($request));
        $this->storeImage($book);
        return redirect('book')->with('message','book has been updated successfully ^_^');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('book')->with('deleted','book has been deleted successfully :(');
    }

    private function storeImage($book)
    {
        if (request()->has('image')) {
            $book->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }
    }

    private function validateRequest($request){
        return $request->validate([
            'title'=>'required|min:3|unique:books,title,Null,id,deleted_at,NULL',
            'description'=>'required|min:10|string',
            'author'=>'required|string',
            'copies'=>'required|integer|min:1|max:100',
            'price_per_day'=>'required|numeric|min:1|max:100',
            'image' => 'sometimes|file|image',
            'category_id'=>'required|integer'
        ]);
    }
}
