@extends('layouts.app')

@section('title', 'My Favourite Books')
@push('styles')

@endpush    
@section('content')

<div class="container">
<h1>My Favourite Books</h1>

<div class="card-decks ">
    <div class="row offset-sm-0 offset-md-2 offset-lg-1 ">
        
    @forelse ($fav_books as $book)
        <div class="card m-2  col-sm-12 col-md-4 col-lg-3" >
            <a href="/book/{{$book->id}}">
                <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{$book->title}} Book Image">
            </a>
            <div class="card-body">
                <h5 class="card-title">{{$book->title}}</h5>
                <p class="card-text">{{$book->description}}</p>
            </div>
        </div>
    @empty
        <p class="alert alert-danger p-2 ">There is No Favourite Bokks  Yet ! <strong>Add one</strong></p>
    @endforelse
    </div>
  
</div>
</div>

@endsection