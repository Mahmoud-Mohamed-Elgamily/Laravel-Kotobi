@extends('layouts.app')
@section('content')
    <div class="container">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @include('admin.users._modal')
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Username</th>
      <th scope="col">Avatar</th>
      <th scope="col">Email</th>
      <th scope="col">Edit</th>
      <th scope="col">Promotion</th>
      <th scope="col">Activation</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)

    <tr>
      <th scope="row">{{ $user->id }}</th>
      <td>{{ $user->name }}</td>
      <td>{{ $user->username }}</td>
      <td>
        @if($user->avatar != null)
            <img src="{{ asset('storage/' . $user->avatar) }}" class="img-thumbnail" alt="...">
        @else
            <img src="{{ asset('images/' . 'default.jpg') }}" class="img-thumbnail" alt="...">
        @endif
    </td>
    <td>{{ $user->email }}</td>
    <td>
        <a class="btn btn-primary" href="user/{{$user->id}}/edit">Edit</a>
    </td>
    <td>
        @if( $user->is_admin  == 0)
            <button type="submit" onClick="promoteAdmin(this,'{{$user->id}}')" class="btn btn-warning">Promote</button>
        @else
            <button type="submit" onClick="promoteAdmin(this,'{{$user->id}}')" class="btn btn-danger">Demote</button>
        @endif
    </td>
    <td>
        @if( $user->is_active == 0)
            <button type="submit" onClick="activation(this,'{{$user->id}}')" class="btn btn-success">Activate</button>
        @else
            <button type="submit" onClick="activation(this,'{{$user->id}}')" class="btn btn-danger">Deactivate</button>
        @endif
    </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $users->links() }}



<script>

    $(()=>{
        
    })

    function promoteAdmin(btn,user_id) {
        $.ajax({
          url: "/admin/user/promotion",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            user_id:user_id
          },
          success:function(response){
            $(btn).toggleClass(['btn-warning','btn-danger'])
            if(response.success == 'Demoted!'){
                $(btn).text("Promote")
            }else{
                $(btn).text("Demote")
            }
            $('.modal').modal('show')
            $('.modal-body').text(response.success)
          },
          error:function(x,e) {
            $('.modal').modal('show')
            $('.modal-body').text('Operation failed successfully :) !')
          }
         });
    }

    function activation(btn,user_id) {
        $.ajax({
          url: "/admin/user/activation",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            user_id:user_id
          },
          success:function(response){
            $(btn).toggleClass(['btn-success','btn-danger'])
            if(response.success == 'Activated!'){
                $(btn).text("Deactivate")
            }else{
                $(btn).text("Activate")
            }
            $('.modal').modal('show')
            $('.modal-body').text(response.success)
          },
          error:function(x,e) {
            $('.modal').modal('show')
            $('.modal-body').text('Operation failed successfully :) !')
          }
         });
    }
</script>
@endsection
