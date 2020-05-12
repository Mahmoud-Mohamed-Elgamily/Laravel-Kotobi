@extends('layouts.app')
@section('content')
    <div class="container">
    @include('admin.users._modal')
        <div class="row">
            @foreach ($users as $user)
            <div class="card" style="width: 18rem;">
                @if($user->avatar != null)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="card-img-top" alt="...">
                @else
                    <img src="{{ asset('images/' . 'default.jpg') }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <h5 class="card-title"><p>{{ $user->name }}</p></h5>
                    <p class="card-text">{{ $user->email }}</p>
                    @if( $user->is_admin  == 0)
                        <button type="submit" onClick="promoteAdmin(this,'{{$user->id}}')" class="btn btn-warning">Promote</button>
                    @else
                        <button type="submit" onClick="promoteAdmin(this,'{{$user->id}}')" class="btn btn-danger">Demote</button>
                    @endif
                    @if( $user->is_active == 0)
                        <button type="submit" onClick="activation(this,'{{$user->id}}')" class="btn btn-success">Activate</button>
                    @else
                        <button type="submit" onClick="activation(this,'{{$user->id}}')" class="btn btn-danger">Deactivate</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
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
