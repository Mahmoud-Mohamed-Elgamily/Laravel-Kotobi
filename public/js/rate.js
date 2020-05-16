$(function () {
    bookId= document.getElementById('bookId').value;
    userId= document.getElementById('userId').value;
    $("#rateYo").on("rateyo.init", function (e, data) {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: 'http://localhost:8000/book/'+bookId+'/rate',
            success: function (data) {
                if(data['book_rate'].length >0)
                {
                    rating=data['book_rate'][0]['rating'];
                    console.log(rating);
                    $rateYo.rateYo("rating", rating);
                }
                 
            },
            error: function (XMLHttpRequest) {
                // handle error
            }
        });
    });
    var $rateYo = $("#rateYo").rateYo({
        fullStar: true,
    });
    
  $("#rateYo").click(function () {
 
    /* get rating */
    var rating = $rateYo.rateYo("rating");
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/book/'+bookId+'/rate',
        data: {
            'book_rate':rating,
        },
        success: function (data) {
            console.log(data);
        },
        error: function (XMLHttpRequest) {
            // handle error
        }
    });
    
  });

});