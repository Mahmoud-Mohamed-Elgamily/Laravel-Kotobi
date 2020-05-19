@extends('layouts.app')


  
@section('content')
    <h2 style="margin-left:200px;">My Books</h2>
    <div class= "row" style="margin:20px 200px;">
        @forelse ($mybooks as $book)
        <div class="col-3 card" style="margin:10px;">
            <a href="/book/{{$book->id}}">
                <img class="card-img-top" src="{{ asset('storage/' . $book->image) }}" alt="Book Image">
            </a>
            <div class="card-body">
                <h5 class="card-title">{{$book->title}}</h5>
                <p class="card-text">{{$book->description}}</p>
                <span><b> {{$currentDate ->diffInDays(\Carbon\Carbon::parse($book->leaseDetails->where('user_id',Auth::id())->first()->date),false) }} day left for lease </b></span>
            </div>
        </div>  
         @empty
            <p >There is No  Books  Yet </p>
        @endforelse
    </div>

@endsection