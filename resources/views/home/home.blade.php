@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-6 text-center">
    {!! Form::open(['url' => 'search' ,'class'=>"form-inline d-block" ,'method'=>'get']) !!}
      {!! Form::text('search',null,['class' => 'form-control mr-sm-2','placeholder'=>"Search",'aria-label'=>"Search"]) !!}
      {!! Form::submit('Search',['class'=>'btn btn-outline-primary my-2 my-sm-0'])  !!}
    {!! Form::close() !!}
 
    </div>
    <div class="col-sm-6 text-center">
      <div class="btn-group" role="group" aria-label="Basic example">
        <a href="/sort/rating" class="btn btn-light btn-outline-primary">Rate</a>
        <a href="/sort/created_at" class="btn btn-light btn-outline-primary">Latest</a>
      </div>
    </div>
  </div>
  <br>

  <div class="row">
    
    <div class="col-2">
      <div class="row">
        <h3>Categories</h3>
        @foreach ($categories as $category)
            <a href="/books/{{$category->id}}" class='mt-2 mr-1'>
            <span class="badge badge-secondary">{{$category->name}}</span>
          </a>
        @endforeach
      </div>
    </div>

    <div class="col-10">
      <div class="row">
        @if (count($books))
          @foreach($books as $book)
            <div class="col-md-3">
              <div class="card">
                <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{$book->title}}">
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
                    {{$book->description}}
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
        @else
            <h1>There's no results</h1>
        @endif
          
      </div>
    </div>
  </div>
  {{ $books->links() }}
</div>
<script>
  function search() {
        let searchBox=document.getElementById('search-box').value
        console.log(searchBox)
        
    }

</script>
@endsection