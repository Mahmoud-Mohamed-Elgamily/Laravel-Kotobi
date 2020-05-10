@extends('layouts.app')

@section('title', 'Edit Book'.$book->title)
    

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Edit Book for: {{$book->title}}</h3>
            </div>
        </div>
    
        <div class="row">
            <div class="col-6">
                <form action="{{ route('book.update', ['book'=> $book]) }}" id="bookForm" method="POST">
                    @method('PATCH')
                    @include('books.form')
                    
                    <button type="submit" class="btn btn-primary">Save book</button>
                </form>
            </div>
        </div>
    </div>
@endsection