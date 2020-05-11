<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    // $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::paginate(6);
        if (Auth::check()) {
            $rate_sum = 0;
            foreach ($books as $book) {
                foreach ($book->rate as $rate) {
                    $rate_sum += $rate->rating;
                }
                $rate_sum = $rate_sum / count($book->rate);
                $book['rating'] = $rate_sum;
                $rate_sum = 0;
            }
            // dd($books);
            return view('home.home', ['books' => $books]);
        } else {
            return view('home.landing', ['books' => $books]);
        }
    }
}
