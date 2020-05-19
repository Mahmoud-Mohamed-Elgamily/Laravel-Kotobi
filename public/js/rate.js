$(function () {
    bookId= document.getElementById('bookId').value;
    userId= document.getElementById('userId').value;
    var $rateYo = $("#rateYo").rateYo({
        fullStar: true,
    });
    
  $("#rateYo").click(function () {
    $('#Rating').html("Your Rating");
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