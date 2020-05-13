@extends('layouts.app')
@section('content')
    <div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif
        {!! Form::model($user, ['route' => ['update_user', $user->id] ,'files' => true]) !!}
            {!! Form::label('name', 'name') !!}
            {!! Form::text('name') !!}
            {!! Form::label('Username', 'Username') !!}
            {!! Form::text('username') !!}
            {!! Form::label('email', 'email') !!}
            {!! Form::text('email') !!}
            {!! Form::label('avatar', 'avatar') !!}
            {!! Form::file('avatar') !!}
            {!! Form::submit('Update User',['class'=>'btn btn-primary'])  !!}
        {!! Form::close() !!}
    </div>
@endsection