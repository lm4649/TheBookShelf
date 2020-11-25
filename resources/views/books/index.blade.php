@extends('app')

@section('content')
<style>
    .header {
        position: sticky;
        top:0;
        background-color: #343a40;
    }
    .container {
      max-height: 90vh;
      overflow: auto;
    }
</style>
<div class="container">
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <table class="table table-hover table-striped table-dark">
    <thead class = "header">
      <tr>
        <th scope="col" class = "header">
          <a href="#" data-toggle="tooltip" data-placement="left" title="sort by titles">
            Title
          </a>
        </th>
        <th scope="col" class = "header">
          <a href="#" data-toggle="tooltip" data-placement="bottom" title="sort by authors">
            Author
          </a>
        </th>
        <th scope="col" class="header text-center"><a href="#" data-toggle="modal" data-target="#form_to_add">Add a book</a></th>
      </tr>
    </thead>
    <tbody style="height: 500px; overflow-y: auto;">
      @if ($books->count())
        @foreach($books as $book)
        <tr>
          <td>{{$book->title}}</td>
          <td>{{$book->author}}</td>
          <td class="d-flex justify-content-center align-items-center">
            <a href="#" class="btn">
              <i class="far fa-edit text-white" data-toggle="tooltip" data-placement="left" title="edit this book"></i>
            </a>
            <span> | </span>
            <a href="#" class="btn" data-toggle="modal" data-target="{{ '#delete-modal' . $book->id}}">
              <i class="far fa-trash-alt text-white" data-toggle="tooltip" data-placement="right" title="remove this book"></i>
            </a>
            <x-delete-form :book="$book" />
          </td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="3" class="text-center">There are no books</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
@endsection
