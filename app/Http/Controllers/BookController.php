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

    // show list of books ordered by titles
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

    // show list of books ordered by authors
    public function by_author(Request $request)
    {
      if ($request->old('search') || $request->input('search'))
      {
        $search = $request->old('search') ? $request->old('search') : $request->input('search');
        $books = $this->search_books($search, 'author');
        $request->flashOnly('search');
      }
      else
      {
        $books = Book::all()->sortBy('author');
      }
      return view('books.index', ['books' => $books]);
    }

     // export the list CSV or XML
    public function export(Request $request)
    {
      $columns = [
        'titles' => $request->input('Title'),
        'authors'=> $request->input('Author'),
      ];

      // if user forgot to pick columns select both for him/her
      if ($columns['titles'] == null && $columns['authors'] == null)
      {
        $columns['titles'] = 'Title';
        $columns['authors'] = 'Author';
      }

      // then checked type of select file
      if( $request->input('fileFormat') == 'CSV')
      {
        $response = $this->export_CSV($columns);
      }
      else
      {
        $response = $this->export_XML($columns);
      }

      return response()->stream($response[0], $response[1], $response[2]);
    }

//---------------------------PRIVATE METHODS----------------------------------//

    protected function search_books($term, $order = 'created_at')
    {
      // prevent app to crash if user press search button without input
      if ($term == null)
      {
        return Book::all()->sortDesc();
      }

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

    protected function export_CSV(array $args)
    {

      $fileName = 'books.csv';
      $books = Book::all()->sortDesc();
      $columns = $args['titles'] == 'Title' ? [$args['titles'], $args['authors']] : [$args['authors']];
      //dd($columns);
      // callback function required for streaming file
      $callback = function() use($books, $columns)
      {
          // create CSV file
          $file = fopen('php://output', 'w');

          // fill it according to selected columns by user
          fputcsv($file, $columns);
          foreach ($books as $book) {
              $rows = [];
              $rows[]= $columns[0] == 'Title' ?  $book->title : $book->author;
              if($columns[1] == 'Author')
              {
                $rows[]= $book->author;
              }

              fputcsv($file, $rows);
          }

          fclose($file);
      };

      // prepare headers for response
      $headers = array(
          "Content-type"        => "text/csv",
          "Content-Disposition" => "attachment; filename=$fileName",
          "Pragma"              => "no-cache",
          "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
          "Expires"             => "0"
      );

      return [$callback, 200, $headers];
    }

    private function export_XML(array $args)
    {
      $fileName = "books.xml";
      $books = Book::all()->sortDesc();
      $columns = $args;

      // callback function required for streaming file
      $callback = function() use($books, $fileName, $columns)
      {
        // create the xml document
        $xml = new \DOMDocument('1.0', 'utf-8');
        $root = $xml->appendChild($xml->createElement("book_listing"));

        // add each book to the xml doc according to selected columns by user
        foreach ($books as $book)
        {
          $element = $root->appendChild($xml->createElement("book"));
          if ($columns['titles'] == 'Title')
          {
            $element->appendChild($xml->createElement("title", $book->title));
          }
          if ($columns['authors'] == 'Author')
          {
            $element->appendChild($xml->createElement("author", $book->author));
          }
        }

        // output xml doc
        $xml->formatOutput = true;
        echo $xml->saveXML();
      };

      // prepare header for response
      $headers = array(
          "Content-type"        => "application/xml",
          "Content-Disposition" => "attachment; filename=$fileName",
          "Pragma"              => "no-cache",
          "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
          "Expires"             => "0"
      );

      // send xml doc
      return [$callback, 200, $headers];
    }

}
