@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                    <div class="card-body">
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
                        <div class="form-group row">
                            {!! Form::label('name', 'name',['class' => 'col-md-4 col-form-label text-md-right']) !!}
                            <div class="col-md-6">
                            {!! Form::text('name',null,['class' => 'form-control '.($errors->has('name') ? 'border-danger':'')]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                        {!! Form::label('Username', 'Username',['class' => 'col-md-4 col-form-label text-md-right']) !!}
                            <div class="col-md-6">
                            {!! Form::text('username',null,['class' => 'form-control '.($errors->has('username') ? 'border-danger':'')]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                        {!! Form::label('email', 'email',['class' => 'col-md-4 col-form-label text-md-right']) !!}
                            <div class="col-md-6">
                            {!! Form::text('email',null,['class' => 'form-control '.($errors->has('email') ? 'border-danger':'')]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                        {!! Form::label('avatar', 'avatar',['class' => 'col-md-4 col-form-label text-md-right']) !!}
                            <div class="col-md-6">
                            {!! Form::file('avatar') !!}
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Update User',['class'=>'btn btn-primary'])  !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection