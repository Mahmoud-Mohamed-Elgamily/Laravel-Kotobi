@extends('layouts.app')

@section('title', 'Add Category')
    


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Add Category</h3>
            </div>
        </div>
    
        <div class="row">
            <div class="col-6">
                <form action="{{route('category.store')}}" method="POST">
                    
                    @include('categories.form')
    
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection
