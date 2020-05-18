<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use Auth;
class FavouriteController extends Controller
{
    public function removefavorite(Request $request)
    {
        // dd($request->user_id);
        $deletedRows = Favourite::where(['user_id'=> $request->user_id,'book_id'=>$request->book_id])->delete();
        return response()->json($deletedRows );
    }
    public function addfavorite(Request $request)
    {
        Favourite::create(['user_id'=> $request->user_id,'book_id'=>$request->book_id]);
        return response()->json('added');
    }
    public function show()
    {
        $favs_records = Auth::user()->favourites;
        $books = [];
        foreach ($favs_records as $record) {
            array_push($books,$record->book);
        }
        return view('favourite.index', 
        [
            'fav_books' => $books 

        ]);
        
    }
}
