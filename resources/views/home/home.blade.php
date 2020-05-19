@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 text-center">
            {!! Form::open(['url' => 'search' ,'class'=>"form-inline d-block" ,'method'=>'get']) !!}
            {!! Form::text('search',null,['class' => 'form-control mr-sm-2','placeholder'=>"Search By title or Author",'aria-label'=>"Search"]) !!}
            {!! Form::submit('Search',['class'=>'btn btn-outline-primary my-2 my-sm-0']) !!}
            {!! Form::close() !!}

        </div>
        <div class="col-sm-6 text-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/sort/rating" class="btn btn-light btn-outline-primary">Rate</a>
                <a href="/sort/created_at" class="btn btn-light btn-outline-primary">Latest</a>
            </div>
        </div>
    </div>
    <br>

    <div class="row">

        <div class="col-2">
            <div class="row">
                <h3>Categories</h3>
                @foreach ($categories as $category)
                <a href="/books/{{$category->id}}" class='mt-2 mr-1'>
                    <span class="badge badge-secondary">{{$category->name}}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="col-10">
            <div class="row">
                @if (count($books))
                @foreach($books as $book)
                <div class="col-md-3">
                    <div class="card book-{{$book->id}}">
                        <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="{{$book->title}}">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$book->title}} <strong>By </strong> {{$book->author}}
                            </h5>
                            @php $rating = $book->rating; @endphp
                            @foreach(range(1,5) as $i)
                            <span class="fa-stack" style="width:1em" data-toggle="tooltip" data-placement="top" title="{{$book->rating}}">
                                <i class="far fa-star fa-stack-1x"></i>
                                @if($rating >0)
                                @if($rating >0.5)
                                <i class="fas fa-star fa-stack-1x"></i>
                                @else
                                <i class="fas fa-star-half fa-stack-1x"></i>
                                @endif
                                @endif
                                @php $rating--; @endphp
                            </span>
                            @endforeach

                            <p class="card-text">
                                {{$book->description | substr:0,50}}
                                <a href="/book/{{$book->id}}"> ...More </a>
                            </p>
                            <small class="mr-auto">
                                <span> {{ $book->copies }} </span> copies available
                            </small>
                            <a href="/book/favourite/{{$book->id}}"> </a>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary lease"
                                data-target="#updateFormModal" data-toggle="modal"
                                onclick="doLease(this,'{{$book->title}}','{{$book->id}}','{{$book->price_per_day}}')"
                                @if($book->copies <= 0) disabled  @endif >
                                Lease
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>There's no results</h1>
                @endif

            </div>
        </div>
    </div>
    {{ $books->links() }}
</div>

<div class="modal fade" id="updateFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Update Speaker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="text-center" id="leaseForm">
                <div class="row px-4 py-1">
                    <div class="input-group col-sm-12 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Book id</label>
                        </div>
                        <input id="bId" type="number" class="form-control" name="book_id" readonly>
                    </div>
                </div>
                <div class="row px-4 py-1">
                    <div class="input-group col-sm-12 col-md-6 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Title</label>
                        </div>
                        <input id="title" type="text" class="form-control" name="book_title" readonly>
                    </div>
                    <div class="input-group col-sm-12 col-md-6 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Price/day</label>
                        </div>
                        <input id="pricePerDay" type="number" class="form-control" name="price_per_day" readonly>
                    </div>
                </div>
                <div class="row px-4 py-1">
                    <div class="input-group col-sm-12 col-md-6 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">from</label>
                        </div>
                        <input id="from" type="date" class="form-control" name="from" readonly>
                    </div>
                    <div class="input-group col-sm-12 col-md-6 mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text">until</label>
                        </div>
                        <input id="until" type="date" class="form-control" name="date" onchange="calcDays(this)">
                    </div>
                </div>
                <input id="price" type="number" class="form-control" name="price" hidden>
                <input id="days" type="number" class="form-control" name="days" hidden>
                <h3 id="submitMessage"></h3>
                <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
<script>
    $('#updateFormModal').on('hide.bs.modal', function(e) {
        $("#until").val('');
        $("#submitMessage").text('')
    })

    function doLease(e, name, bookId, price) {
        $("#bId").val(bookId);
        $("#title").val(name);
        $("#pricePerDay").val(price);
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#from").val(today);
        $("#until").attr('min', today);
    }

    const calcDays = (e) => {
        var olddate = new Date($("#from").val());
        var newdate = new Date($(e).val());
        var timeDiff = Math.abs(newdate.getTime() - olddate.getTime());
        var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
        let price = calcPrice(days, $("#pricePerDay").val());
        $("#submitMessage").text(`you will lease this book for ${days} days for the price of ${price}`)
        $("#days").val(days);
        $("#price").val(price);
    }

    const calcPrice = (days, price) => {
        return days * price;
    }

    $("#leaseForm").submit(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: $(this).attr('method'),
            url: `/user/{{ Auth::user()->id }}/lease/${$("#bId").val()}`,
            data: $(this).serialize(),
            datatype: "json",
            success: function(msg) {
                let copies = $(`.book-${$("#bId").val()} div small span`);
                copies.text(copies.text()-1);
                if(copies.text()<=0){
                    $(`.book-${$("#bId").val()} div button`).attr('disabled',true);
                }
                console.log(msg);
            },
            error: function(err) {
                alert('wrong data');
            }
        });
        $("#until").val('');
        $("#submitMessage").text('')
        $('#updateFormModal').modal('toggle');

        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    function search() {
        let searchBox = document.getElementById('search-box').value
        console.log(searchBox)

    }
</script>
@endsection
