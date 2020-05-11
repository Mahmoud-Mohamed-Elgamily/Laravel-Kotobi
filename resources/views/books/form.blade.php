<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" placeholder="title" value="{{ old('title') ?? $book->title}}" class="form-control">
</div>
<div><span class="text-muted">{{$errors->first('title') }}</span></div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea rows="3" cols="59" name="description" form="bookForm" placeholder="Enter book details here...">{{ old('description') ?? $book->description}}</textarea>
</div>
<div>{{$errors->first('description') }}</div>

<div class="form-group">
    <label for="author">Author</label>
    <input type="text" name="author" placeholder="author" value="{{ old('author') ?? $book->author}}" class="form-control">
</div>
<div>{{$errors->first('author') }}</div>

<div class="form-row">
    <div class="form-group col-md-3">
        <label for="copies">Copies</label>
        <input type="number" name="copies" value="{{ old('copies') ?? $book->copies}}" class="form-control">
    </div>
    <div>{{$errors->first('copies') }}</div>

    <div class="form-group col-md-3">
        <label for="price_per_day">Price</label>
        <input type="number" name="price_per_day" step="0.01" value="{{ old('price_per_day') ?? $book->price_per_day}}" class="form-control">
    </div>
    <div>{{$errors->first('price_per_day') }}</div>
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" >
</div>
<div>{{$errors->first('image') }}</div>

<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="" disabled>Select ur category</option>
        @foreach ($categories as $category)
            <option value="{{$category->id}}" {{$category->id == $book->category_id ? 'selected' : ''}} >{{$category->name}}</option>
        @endforeach
    </select>
</div>

@csrf