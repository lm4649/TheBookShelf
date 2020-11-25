<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

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

    //-----------------------PRIVATE METHODS----------------------------------//

    protected function search_books($term, $order = 'created_at')
    {
      $search = '%' . trim($term) . '%';
      $reversed_search = '%' . trim($this->reverse_words($term)) . '%';
      $books = DB::table('books')->distinct()
                                  ->where('title','like', $search)
                                  ->orWhere('title', 'like', $reversed_search)
                                  ->orWhere('author', 'like', $search)
                                  ->orWhere('author', 'like', $reversed_search)
                                  ->orderBy($order)
                                  ->get();
      return $books;
    }

    protected function reverse_words(string $term)
    {
      $search_terms = explode( ' ', $term);
      return join(" ", array_reverse($search_terms));
    }
}
