@extends('layouts.app')

@section('title', 'Edit Category'.$category->name)
    


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Edit Category for: {{$category->name}}</h3>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <form action="{{ route('category.update', ['category'=> $category]) }}" method="POST">
                    @method('PATCH')
                    @include('categories.form')
                    
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection