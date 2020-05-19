@extends('layouts.app')

@section('title', 'Books')
    
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<main>
    <div class="container dark-grey-text mt-5">
        <div class="row">
            <div class="col-md-6 mb-4" >
                <img src="{{ asset('storage/' . $book->image) }}" class="img-fluid" style="width:500px;height:260px;object-fit: cover;">
                @if(Auth::user()->is_admin == false)
                    <!-- rating -->
                    <div style="margin-top:30px;">
                        <h4>Rate this book </h4>
                        <span id="rateYo" >
                            <input type="hidden" id="bookId" value="{{$book->id}}">
                            <input type="hidden" id="userId" value="{{Auth::user()->id}}">
                        </span>
                    </div>
                @endif
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4">
                    <p class="lead">
                    <div>
                    </div>
                        <span>${{$book->price_per_day}}</span>
                        <span class="badge badge-warning mt-0">per day</span>
    
                        <span  class="text-danger float-right fav-remove" style="{{ $is_favourite ? '' : 'display: none;' }}" onclick="removeFav({{$book->id}},{{Auth::user()->id}})">
                            <i class="fa fa-heart fa-2x ml-1"></i>
                        </span>
                        <span class="text-muted float-right fav-add" style="{{ $is_favourite ? 'display: none;' : '' }}" onclick="addFav({{$book->id}},{{Auth::user()->id}})"> 
                            <i class="fa fa-heart fa-2x ml-1"></i>
                        </span>
                       

                    </p>
                    <p class=" font-weight-bold text-muted">Author: {{$book->author}}</p>
                    <p class="lead font-weight-bold">Description</p>
                    <p>{{$book->description}}</p>
                    <form class="d-flex justify-content-left">
                        <input type="number" value="1" aria-label="Search" class="form-control" style="width: 100px">
                        <button class="btn btn-primary ml-2" type="submit">
                            Lease
                            <i class="fas fa-shopping-cart ml-1"></i></button>
                    </form>
                </div>
                
                
                
            </div>
        </div>
        <div class="row">
        @include('books.comments')
        </div>
    </div>
</main
@push('scripts')
    <script src="{{ asset('js/book.js') }}" defer></script>
    @if(Auth::user()->is_admin == false)
    <script src="{{ asset('js/rate.js') }}" defer></script>
    <!-- star rating -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    @endif
@endpush
@endsection
