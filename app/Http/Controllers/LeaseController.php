<?php

namespace App\Http\Controllers;

use App\Book;
use App\LeaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    public function store(Request $request,$userid,$bookId)
    {
        // book_id=2&book_title=doloribus+sequi&price_per_day=9&from=2020-05-18&date=
        // echo($request->getContent());

        $lease = new LeaseDetail;
        $lease->date = $request->date;
        $lease->days = $request->days;
        $lease->price = $request->price;
        $lease->user_id = $userid;
        $lease->book_id = $bookId;
        $lease->save();

        DB::table('books')
            ->where('id', $bookId)
            ->decrement('copies');

        return response('success', 200);

        // book_id=2&book_title=doloribus+sequi&price_per_day=81&from=2020-05-18&date=2020-05-27&price=&days=9

        // $book = LeaseDetail::create($this->validateRequest($request));
        // return redirect('book')->with('message','a new book has been added ');
    }

}
