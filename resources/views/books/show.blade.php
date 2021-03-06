@extends('layouts.app')

@section('title', 'Books')
    
@section('content')
@if (session()->has("deleted"))
<div class="alert alert-success" role="alert">
    <strong>Success</strong> {{session()->get("deleted")}}
  </div>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<main>

    <div class="container dark-grey-text mt-5">
        <div class="alert alert-success add-alert" 
        role="alert" style="display:none">
        <strong>Sucessfully  </strong> Added to favorite.
        </div>
        <div class="alert alert-danger remove-alert" 
        role="alert" style="display:none">
        <strong>Sucessfully  </strong> Removed from favorite.
        </div>
        <div class="row">
            <div class="col-md-6 mb-4" >
                <img src="{{ asset('storage/' . $book->image) }}" class="img-fluid" style="width:500px;height:260px;object-fit: cover;">
               
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4">
                    <p class="lead">
                        <h2>{{$book->title}}</h2>
                    <div>
                    </div>
                        <span>${{$book->price_per_day}}</span>
                        <span class="badge badge-warning mt-0">per day</span>
    
                        <span  class="text-danger float-right fav-remove" 
                        style="{{ $is_favourite ? '' : 'display: none;' }}" 
                        onclick="removeFav({{$book->id}},{{Auth::user()->id}})">
                            <i class="fa fa-heart fa-2x ml-1"></i>
                        </span>
                        <span class="text-muted float-right fav-add" 
                        style="{{ $is_favourite ? 'display: none;' : '' }}" 
                        onclick="addFav({{$book->id}},{{Auth::user()->id}})"> 
                            <i class="fa fa-heart fa-2x ml-1"></i>
                        </span>
                       

                    </p>
                    <p class=" font-weight-bold text-muted">
                        Author: {{$book->author}}</p>
                    <p class="lead font-weight-bold mb-1">Description</p>
                    <p class="mb-1">{{$book->description}}</p>
                    <small class=" mb-2 {{$book->copies ==0 ? 'text-white badge badge-danger':'text-white badge badge-success'}}">
                            @if ($book->copies == 0)
                                Not Available
                                </small>  
                            @else
                                {{$book->copies}} copies available
                  
                    </small>
                    <form class="d-flex justify-content-left">
                        <!-- <input type="number" value="1" aria-label="Search" 
                        class="form-control" style="width: 100px"> -->
                        <button class="btn btn-primary " type="submit">
                            Lease
                            <i class="fas fa-shopping-cart ml-1"></i></button>
                            
                    </form>
                    @endif
                </div>
                
                
                
            </div>
        </div>
        <div class="row">
        @include('books.comments')
        </div>
        <div class="row">
        <!-- equal = 1 means only current book exist in this category 
        and there is no related books-->
        @if(count($related_items)==1)

        @elseif(count($related_items)>5)
            @include('books.related')
        @else
            @include('books.related_less')
        @endif
        
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
