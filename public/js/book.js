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
            console.log(data);
            // hide add button
            $('.fav-remove').hide();
            // show delete button
            $('.fav-add').show();
        },
        error: function (XMLHttpRequest) {
            // handle error
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
            console.log(data);
            // hide add button
            $('.fav-add').hide();
            // show delete button
            $('.fav-remove').show();
        },
        error: function (XMLHttpRequest) {
            // handle error
        }
    });
}