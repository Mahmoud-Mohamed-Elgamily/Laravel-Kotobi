<div class="container">
    <div class="row">
        <div class="col-12">
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
       
    </div>
    <div class="cards">
    @forelse ($comments as $comment)
        <div class="card mt-4">
            <div class="card-header pl-2">
                <h6 class="card-title">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{date('d-m-Y g:ia', strtotime($comment->created_at))}}
</small>
                <!-- <small class="text-muted">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</small> -->
            </div>
            <div class="card-body">
                
                <p class="card-text">{{$comment->comment_body}}</p>
            </div>
            
        </div>
    @empty
        <p class="text-danger border p-2 no-comment">No Comments  Yet !</p>
    @endforelse
    </div>
</div>
