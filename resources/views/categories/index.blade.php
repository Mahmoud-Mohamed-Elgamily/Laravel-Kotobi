@extends('layouts.app')

@section('title', 'Categories')
    
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
            <h3>Categories</h3>
                <p><a href="{{route('category.create')}}" class="btn btn-primary" >Add category</a></p>
        </div>
    </div>

    <table class="table text-center">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
            @php
                $counter = 0;    
            @endphp
            @foreach ($categories as $category)
                <tr>
                <th scope="row">{{$counter+=1}}</th>
                    <td>{{$category->name}}</td>
                    <td>
                        <a href="{{route('category.edit',['category'=>$category])}}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('category.destroy',['category'=>$category])}}" method="POST">
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