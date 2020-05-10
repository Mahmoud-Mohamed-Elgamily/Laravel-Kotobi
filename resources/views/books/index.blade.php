@extends('layouts.app')

@section('title', 'Books')
    
@section('content')
@if (session()->has("message"))
<div class="alert alert-success" role="alert">
    <strong>Success</strong> {{session()->get("message")}}
  </div>
@endif
@if (session()->has("deleted"))
<div class="alert alert-warning" role="alert">
    <strong>Success</strong> {{session()->get("deleted")}}
  </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Books</h3>
                <p><a href="{{route('book.create')}}" class="btn btn-primary" >Add book</a></p>
        </div>
    </div>

    <table class="table text-center">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;    
            @endphp
            @foreach ($books as $book)
                <tr>
                <th scope="row">{{$counter+=1}}</th>
                    <td>{{$book->title}}</td>
                    <td>@if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" alt="" class="img-thumbnail" style="width: 60px; height:60px">
                    @endif</td>
                    <td>
                        <a href="{{route('book.edit',['book'=>$book])}}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('book.destroy',['book'=>$book])}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection