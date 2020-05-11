@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-6 text-center">
      <form class="form-inline d-block">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
    <div class="col-sm-6 text-center">
      <div class="btn-group" role="group" aria-label="Basic example">
        <a href="/book/filter/rate" class="btn btn-light btn-outline-primary">Rate</a>
        <a href="/book/filter/latest" class="btn btn-light btn-outline-primary">Latest</a>
      </div>
    </div>
  </div>
  <br>

  <div class="row">
    @foreach($books as $book)
    <div class="col-md-4">
      <div class="card">
        <img src="storage/images/{{$book->image}}" class="card-img-top" alt="{{$book->title}}">
        <div class="card-body">
          <h5 class="card-title">
            {{$book->title}} <strong>By </strong> {{$book->author}}
          </h5>
          @php
          $rating = $book->rating;
          @endphp
          @foreach(range(1,5) as $i)
          <span class="fa-stack" style="width:1em" data-toggle="tooltip" data-placement="top" title="{{$book->rating}}">
            <i class="far fa-star fa-stack-1x"></i>
            @if($rating >0)
              @if($rating >0.5)
                <i class="fas fa-star fa-stack-1x"></i>
              @else
                <i class="fas fa-star-half fa-stack-1x"></i>
              @endif
            @endif
            @php $rating--; @endphp
          </span>
          @endforeach

          <p class="card-text">
            {{$book->description | substr:0,100 }}
            <a href="/book/{{$book->id}}"> ...Read More </a>
          </p>
          <small class="mr-auto">
            {{ $book->copies }} copies available
          </small>
          <a href="/book/favourite/{{$book->id}}"> </a>
        </div>
        <div class="card-footer">
          <a class="btn btn-primary lease" href="/book/lease/{{$book->id}}">
            Lease
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  {{ $books->links() }}
</div>
@endsection