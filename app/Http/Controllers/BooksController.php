<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use App\Charts\BooksProfit;
use App\LeaseDetail;
use Carbon\Carbon;

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
     * Display books chart
     *
     * @return \Illuminate\Http\Response
     */
    public function chart()
    {
        $data = collect([]);
        $labels = collect([]);
        $chart = new BooksProfit;
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $year=Carbon::now()->year;
        $month=Carbon::now()->month;
        //SOL ONE
        // $result= LeaseDetail::select('created_at','price')->whereYear('created_at', Carbon::today()->year)->whereMonth('created_at' , Carbon::today()->month)->get()
        // ->groupBy( function($date){ return Carbon::parse($date->created_at)->weekOfMonth; })->map(function ($row){ return $row->sum('price');});
        
        // $chart->labels([Carbon::createFromDate($year, $month, 1)->format('M d Y'),
        //     Carbon::createFromDate($year, $month, 7),
        //     Carbon::createFromDate($year, $month, 14)->format('M d Y'),
        //     Carbon::createFromDate($year, $month, 21),
        //     Carbon::createFromDate($year, $month+1, 1)->format('M d Y')
        //     ]);
        // foreach($result as $item){
        //     $data->push($item);
        // }

        //SOL TWO
        $result= LeaseDetail::select('created_at','price')->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
        ->get()->groupBy( function($date){  return Carbon::parse($date->created_at)->format('M d Y'); })->map(function ($row){ return $row->sum('price');})->toArray();   
        $weekStart=Carbon::now()->startOfWeek();
        $weekEnd=Carbon::now()->endOfWeek();
        $dateInterval = \DateInterval::createFromDateString('1 day');
        $days = new \DatePeriod($weekStart, $dateInterval, $weekEnd->modify('+1 day'));
        foreach($days as $label)
        {
            $date=$label->format('M d Y');
            $labels->push($date);
            if( array_key_exists($date, $result)  )
            {
                $data->push($result[$date]);
            }
            else
            {
                $data->push(0);
            }
        }      
        $chart->labels($labels);
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
