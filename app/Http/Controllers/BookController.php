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

    // add a book
    public function store(Request $request)
    {

     // validation
      $this->validate($request, [
        'title' => 'required|unique:books|max:255',
        'author' => 'required|max:255'
      ]);

      // store book
      $book = Book::create([
        'title' => $request->title,
        'author' => $request->author
      ]);
      $book->save();

      // redirect to the book list
      return redirect()->route('books')->with('status', $book->title . ' has been added to the shelf;-)');
    }

    // delete a book
    public function destroy(int $id)
    {
      $book = Book::find($id);
      $title = $book->title;
      $book->delete();
      return redirect()->route('books')->with('status', $title . ' has been removed from the shelf;-)');
    }

    //edit the author name
    public function update(Request $request, int $id)
    {
      $book = Book::find($id);
      $book->author = $request->input("author");
      $book->save();
      return redirect()->route('books')->with('status', $title = $book->title . ' has been updated;-)');
    }

    // show list of books ordered by title
    public function by_title(Request $request)
    {
      if ($request->old('search') || $request->input('search'))
      {
        $search = $request->old('search') ? $request->old('search') : $request->input('search');
        $books = $this->search_books($search, 'title');
        $request->flashOnly('search');
      }
      else
      {
        $books = Book::all()->sortBy('title');
      }
      return view('books.index', ['books' => $books]);
    }

//---------------------------PRIVATE METHODS----------------------------------//

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
