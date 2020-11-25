@props(['book' => $book])

<div class="modal fade text-dark" id="{{ 'delete-modal' . $book->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{'Do you want to remove ' . $book->title . '?'}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form action="{{ route('destroy', $book->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-primary" data-dismiss="modal">Of course, not!</button>
            <button type="submit" class="btn btn-danger">Remove this book</button>
          </form>
        </div>
    </div>
  </div>
</div>
