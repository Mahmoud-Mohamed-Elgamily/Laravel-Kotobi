function removeFav(bookId,userId){
    let bookID = bookId;
    let userID = userId;

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/removefavorite',
        data: {
            'user_id': userId,
            'book_id': bookID,
        },
        success: function (data) {
            $('.fav-remove').hide();
            $('.fav-add').show();
            $('.remove-alert').show().delay(1500).queue(function(nxt) {
                $(this).hide();
                nxt();
          });

        },
        error: function (XMLHttpRequest) {
            // handle error
            console.log(XMLHttpRequest);
        }
    });
}
function addFav(bookId,userId){
    let bookID = bookId;
    let userID = userId;
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/addfavorite',
        data: {
            'user_id': userId,
            'book_id': bookID,
        },
        success: function (data) {
            
            $('.fav-add').hide();
            $('.fav-remove').show();
            $('.add-alert').show().delay(1500).queue(function(nxt) {
                $(this).hide();
                nxt();
          });

        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest);
        }
    });
}
function addComment(bookId,userId){
    let bookID = bookId;
    let userID = userId;
    let comment = $("textarea").val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/addcomment',
        data: {
            'user_id': userId,
            'book_id': bookID,
            'comment':comment
        },
        success: function (comment) {
            if ("error" in comment ){
                $(".error").text(comment['error']);
                $(".error").show();
                $('textarea').css('border-color', 'red');
            }
            else {
                if ($(".no-comment").length) {
                    $(".no-comment").hide();
                }
                
                $(".error").hide();
                $('textarea').css('border-color', '');
                new_comment = `<div class="card mt-4">
                <div class="card-header pl-2">
                    <h6 class="card-title">${comment['user']}</h6>
                    <small class="text-muted">${comment['date']}</small>
                    <!-- <small class="text-muted">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</small> -->
                </div>
                <div class="card-body">
                    
                    <p class="card-text">${comment['comment']}</p>
                </div>
                
            </div>`;
                $(".cards").append(new_comment);
                $("textarea").val('');
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest);
        }
    });
}
$('textarea').focus(function(){
    $('textarea').css('border-color','');
});

