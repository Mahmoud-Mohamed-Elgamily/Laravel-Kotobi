 <!-- Displayed if more than five books -->

@push('styles')
<link href="{{ asset('css/related.css') }}" rel="stylesheet">
@endpush
<h2 class="ml-3">Related Books</h2>
<!-- Top content -->
<div class="top-content">
    <div class="container-fluid">
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row w-100 mx-auto" role="listbox">
            <!-- IF condition to Prevent displaying current book -->
            @forelse ($related_items as $rel_book)
            @if ($book->id != $rel_book->id) 
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 {{$loop->iteration ==1 ? 'active':''}} ">
                        <img src="{{ asset('storage/' . $rel_book->image) }}" 
                        class="img-fluid mx-auto d-block related" alt="{{$rel_book->title}} Book Image">
                        <h5 class="mt-2">
                        <a href="/book/{{$rel_book->id}}">{{$rel_book->title}}</a>
                    </h5>
                        <small class="text-muted">{{$rel_book->copies}} copies available</small>
                </div>    
            @endif
            @empty 
            <p>No related books available</p>
            @endforelse        
            </div>
            <a class="carousel-control-prev" href="#carousel-example" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@push('scripts')
<script>
/*
    Carousel
*/
$('#carousel-example').on('slide.bs.carousel', function (e) {

    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 5;
    var totalItems = $('.carousel-item').length;
 
    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});


</script>
@endpush