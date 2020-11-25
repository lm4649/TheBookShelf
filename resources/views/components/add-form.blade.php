{{-- shall be placed on top of the body --}}
<div id="form_to_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Let's add a book!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('add')}}" method="post" id="add-form">
          @csrf
          <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input type="text"
                    class="form-control
                    @error('title') border-danger @enderror"
                    id="title"
                    name="title"
                    value="{{@old('title')}}"
                    required
                    oninvalid="this.setCustomValidity('Please Enter a title')"
                    oninput="setCustomValidity('')"
            >
            @error('title')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
          @enderror
          </div>
          <div class="form-group">
            <label for="author" class="col-form-label">Author</label>
            <input type="text"
                    class="form-control
                    @error('author') border-danger @enderror"
                    id="author"
                    name="author"
                    value="{{@old('author')}}"
                    required
                    oninvalid="this.setCustomValidity('Please Enter the author name')"
                    oninput="setCustomValidity('')"
                    placeholder="Usage: Last name First name Middle name"
            >
            @error('author')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
          @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" form="add-form" class="btn btn-success">Add a book</button>
      </div>
    </div>
  </div>
</div>

