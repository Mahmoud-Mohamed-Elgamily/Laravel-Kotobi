@extends('layouts.app')

@section('title', 'Add Book')
    


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Add Book</h3>
            </div>
        </div>
    
        <div class="row">
            <div class="col-6">
                <form action="{{route('book.store')}}" method="POST" id="bookForm" enctype="multipart/form-data">
                    
                    @include('books.form')
    
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>
    </div>
@endsection
