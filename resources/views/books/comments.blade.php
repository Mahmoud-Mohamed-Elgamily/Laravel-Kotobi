
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <h5 class="card-header h5 bg-dark text-light">Comments</h5>
                <div class="card-body">
                    <span class="text-danger error" style="display:none"></span>

                    <textarea class="form-control mb-3 commentBox" placeholder="write a comment..." rows="3"></textarea>
                    <!-- <a href="#" class="btn btn-primary float-right">Post</a> -->
                    <button class="btn btn-primary float-right" onclick="addComment({{$book->id}},{{Auth::user()->id}})">Post</button>
                </div>
            </div>
        </div>
        <div class="offset-lg-1 col-3">
                @if(Auth::user()->is_admin == false)
                    <!-- rating -->    
                    <div style="margin-top:30px;" >
                        <h4>Rate this book </h4>
                        @if($rate)
                        <div id="rateYo" data-rateyo-rating="{{$rate->rating}}"  >
                        </div>
                        @else
                            <div id="rateYo" data-rateyo-rating="0"  >
                            </div>
                        @endif
                        <input type="hidden" id="bookId" value="{{$book->id}}">
                        <input type="hidden" id="userId" value="{{Auth::user()->id}}">
                    </div>
                @endif

        </div>
       
    </div>
    <div class="cards">
    @forelse ($comments as $comment)
        <div class="card mt-4">
            <div class="card-header pl-2">
                <h6 class="card-title">{{ $comment->user->name }}</h6>
                <small class="text-muted">{{date('d-m-Y g:ia', strtotime($comment->created_at))}}
                </small>
                <!-- <small class="text-muted">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</small> -->

                @if($comment->user_id == Auth::user()->id)
                <button class="btn float-right"
                        onclick="removeComment(this,{{$comment->id}})" > 
                        <i class="fas fa-times fa-lg ml-1 text-danger"></i>
                </button>
                @endif
            </div>
            <div class="card-body">
                
                <p class="card-text">{{$comment->comment_body}}</p>
            </div>
            
            
        </div>
    @empty
        <p class="alert alert-danger p-2 no-comment">There is No Comments  Yet ! <strong>Add one</strong></p>
    @endforelse
    </div>
</div>
