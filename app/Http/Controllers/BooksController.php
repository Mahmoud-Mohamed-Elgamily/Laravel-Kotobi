<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\Charts\BooksProfit;
use App\LeaseDetail;
use Carbon\Carbon;

class BooksController extends Controller
{
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
     * Display books chart
     *
     * @return \Illuminate\Http\Response
     */
    public function chart()
    {
        $data = collect([]);
        $result= LeaseDetail::select('created_at','price')->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at' , Carbon::today()->month)->get()
        ->groupBy( function($date){ return Carbon::parse($date->created_at)->weekOfMonth; })->map(function ($row){ return $row->sum('price');});
        $chart = new BooksProfit;
        foreach($result as $item){
            $data->push($item);
        }
        $year=Carbon::now()->year;
        $month=Carbon::now()->month;

        $chart->labels([Carbon::createFromDate($year, $month, 1)->format('M d Y'),
            Carbon::createFromDate($year, $month, 8),
            Carbon::createFromDate($year, $month, 15)->format('M d Y'),
            Carbon::createFromDate($year, $month, 22),
            Carbon::createFromDate($year, $month+1, 1)->format('M d Y')
            ]);
        $chart->dataset('Books Profit per week', 'line', $data);
            
        return view('books.chart',compact('chart'));
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
    public function show(Book $book)
    {
        //
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
