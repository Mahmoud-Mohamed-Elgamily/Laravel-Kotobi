<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Favourite;
use Illuminate\Http\Request;
use Auth;
use App\Charts\BooksProfit;
use App\LeaseDetail;
use Carbon\Carbon;
use App\Rate;
use App\User;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.admin')->except('show','rate','mybooks');
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
        $result= LeaseDetail::select('created_at','price')->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get()->groupBy( function($date){  return Carbon::parse($date->created_at)->format('M d Y'); })->map(function ($row){ return $row->sum('price');})->toArray();
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
     * store book rate
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, Book $book)
    {
        $userId=Auth::user()->id;
        $bookRate=Rate::where([
            ['user_id', '=', $userId],
            ['book_id', '=', $book->id]])->get();
        $rates=$bookRate->toArray();
        // var_dump($bookRate) ;
        if(count($rates)>0)
        {
            $bookRate[0]->update(['rating' => $request->book_rate]);
            echo "update";
        }
        else
        {
            Rate::create(['user_id'=> $userId,'book_id'=>$book->id,'rating'=>$request->book_rate]);
            echo "new";
        }

    }


    /**
     * Display My books.
     *
     * @return \Illuminate\Http\Response
     */
    public function mybooks()
    {
        $this->authorize('mybooks');
        $mybooks=[];
        $User_lease_details = User::where('id',Auth::id())->get()->first()->leaseDetails->where('date','>',Carbon::now());
        // var_dump($User_lease_details);
        foreach ($User_lease_details as $lease_detail) {
            $mybooks[]=$lease_detail->book;
        }
        $currentDate=Carbon::now();
        return view('books.mybooks',compact('mybooks','currentDate'));
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
        $book = Book::findOrFail($id);
        $rate =$book ->rate->where('user_id',Auth::id())->first();
        $comments = $book->comments ;
        $related = Book::where('category_id',$book->category_id)
        ->inRandomOrder()
        ->limit(7)
        ->get();
        $is_favourite = Favourite::where(['user_id'=>Auth::id(),'book_id'=>$id])->get()->count();
        return view('books.show',
        [
            'book' => $book ,
            'is_favourite'=>$is_favourite,
            'comments'=>$comments,
            'related_items'=>$related,
            'rate'=>$rate

        ]);
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
        $book->update($this->validateRequest($request,$book));
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

    private function validateRequest($request,$book){

        return $request->validate([
            'title'=>'required|min:3|unique:books,title,Null,id,deleted_at,NULL'.$book->id,
            'description'=>'required|min:10|string',
            'author'=>'required|string',
            'copies'=>'required|integer|min:1|max:100',
            'price_per_day'=>'required|numeric|min:1|max:100',
            'image' => 'sometimes|file|image',
            'category_id'=>'required|integer'
        ]);
    }
}