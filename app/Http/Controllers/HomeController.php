<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

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

    private function addRate($books)
    {
        $rate_sum = 0;
        foreach ($books as $book) {
            foreach ($book->rate as $rate) {
                $rate_sum += $rate->rating;
            }
            if (count($book->rate)!= 0 ){
                $rate_sum = $rate_sum / count($book->rate);
                $book['rating'] = $rate_sum;
            }
            else {
                $book['rating'] = 0;
            }
            
            $rate_sum = 0;
        }
        return $books;
    }

    public function sort($sort_value)
    {
        $books = Book::paginate(6);
        $books = $this->addrate($books);
        $books->setCollection(
            $books->sortByDesc($sort_value)
        );
        return view('home.home', ['books' => $books]);
    }

    public function index()
    {
        $books = Book::paginate(6);
        if (Auth::check()) {
            $books = $this->addrate($books);
            return view('home.home', ['books' => $books]);
        } else {
            return view('home.landing', ['books' => $books]);
        }
    }
}
