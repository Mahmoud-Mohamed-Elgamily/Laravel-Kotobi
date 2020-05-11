@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    @foreach($books as $book)
    <div class="col-md-4">
      <div class="card">
        <img src="storage/images/{{$book->image}}" class="card-img-top" alt="{{$book->title}}">
        <div class="card-body">
          <h5 class="card-title"> {{$book->title}} <strong>By </strong> {{$book->author}}</h5>
          <p class="card-text">
            {{$book->description | substr:0,100 }}
            <a href="{{ route('login') }}"> ...Login </a>
          </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  {{ $books->links() }}
</div>
@endsection