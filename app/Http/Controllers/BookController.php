<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // show list of books ordered by creation date or a searched list
    public function index(Request $request)
    {
      if ($request->has('search'))
      {
        $request->flashOnly('search');
        $search = $request->input('search');
        $books = $this->search_books($search);
      }
      else
      {
        $books = Book::all()->sortDesc();
      }
      return view('books.index', ['books' => $books]);
    }
}
