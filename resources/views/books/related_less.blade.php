
 <!-- Displayed if less than five books -->

@push('styles')
<style>
    .related {
         width:300px !important;
         height:200px !important;
         object-fit: cover !important;
    }
</style>
@endpush

<div class="top-content">
<h2 class="ml-3">Related Books</h2>
    <div class="container-fluid">

        <div class="card-group ">
        @forelse ($related_items as $rel_book)
        @if ($book->id != $rel_book->id) <!-- Prevent displaying current book -->
            <div class="card ml-4 ">
                <img class="card-img-top img-fluid related" 
                src="{{ asset('storage/' . $rel_book->image) }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/book/{{$rel_book->id}}">{{$rel_book->title}}</a>
                    </h5>
                    <p class="card-text">
                        <small class="text-muted">{{$rel_book->copies}} copies available</small>
                    </p>
                </div>
            </div>
        @endif
        @empty 
        <p>No related books available</p>
        @endforelse   
        </div>

    </div>
</div>