@props(["book" => $book])
<div class="modal fade text-dark" id="{{ 'edit-modal' . $book->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{'Let\'s change the author of ' . $book->title . ' !'}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('update', $book->id) }}" method="post" id="{{'edit-form' . $book->id }}">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="author" class="col-form-label">Author</label>
            <input type="text"
                    class="form-control
                    @error('author') border-danger @enderror"
                    id="author"
                    name="author"
                    value="{{@old('author')}}"
                    required
                    oninvalid="this.setCustomValidity('Please modify the author\'s name')"
                    oninput="setCustomValidity('')"
                    placeholder="{{ $book->author }}"
            >
            @error('author')
            <div class="text-sm text-danger">
              {{$message}}
            </div>
          @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" form="{{'edit-form' . $book->id }}" class="btn btn-success">Edit this book</button>
      </div>
    </div>
  </div>
</div>
