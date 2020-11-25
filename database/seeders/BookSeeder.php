<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // clear the DB first
        DB::table('books')->delete();

        // fill the DB with the top 50 best books
        foreach ($this->books() as $book) {
            $book = new Book($book);
            $book->save();
        }
    }

    protected function books()
    {
      // list of the top 50 books of all time
      // source: https://thegreatestbooks.org/
      $data = [
        'In Search of Lost Time by Marcel Proust',
        'Ulysses by James Joyce',
        'Don Quixote by Miguel de Cervantes',
        'The Great Gatsby by F. Scott Fitzgerald',
        ' One Hundred Years of Solitude by Gabriel Garcia Marquez',
        'Moby Dick by Herman Melville',
        'War and Peace by Leo Tolstoy',
        'Lolita by Vladimir Nabokov',
        'Hamlet by William Shakespeare',
        'The Catcher in the Rye by J. D. Salinger',
        'The Odyssey by Homer',
        'The Brothers Karamazov by Fyodor Dostoyevsky',
        'Crime and Punishment by Fyodor Dostoyevsky',
        'Madame Bovary by Gustave Flaubert',
        'The Divine Comedy by Dante Alighieri',
        'The Adventures of Huckleberry Finn by Mark Twain',
        'Alice\'s Adventures in Wonderland by Lewis Carroll',
        'Pride and Prejudice by Jane Austen',
        'Wuthering Heights by Emily Brontë',
        'To the Lighthouse by Virginia Woolf',
        'Catch-22 by Joseph Heller',
        'The Sound and the Fury by William Faulkner',
        'Nineteen Eighty Four by George Orwell',
        'Anna Karenina by Leo Tolstoy',
        'The Iliad by Homer',
        'Heart of Darkness by Joseph Conrad',
        'The Grapes of Wrath by John Steinbeck',
        'Invisible Man by Ralph Ellison',
        'To Kill a Mockingbird by Harper Lee',
        'Middlemarch by George Eliot',
        'Great Expectations by Charles Dickens',
        'Gulliver\'s Travels by Jonathan Swift',
        'Absalom, Absalom! by William Faulkner',
        'Beloved by Toni Morrison',
        'The Stranger by Albert Camus',
        'Jane Eyre by Charlotte Bronte',
        'One Thousand and One Nights by India/Iran/Iraq/Egypt',
        'The Trial by Franz Kafka',
        'The Red and the Black by Stendhal',
        'Mrs. Dalloway by Virginia Woolf',
        'The Stories of Anton Chekhov by Anton Chekhov',
        'The Sun Also Rises by Ernest Hemingway',
        'David Copperfield by Charles Dickens',
        'A Portrait of the Artist as a Young Man by James Joyce',
        'Midnight\'s Children by Salman Rushdie',
        'Collected Fiction by Jorge Luis Borges',
        'Tristram Shandy by Laurence Sterne',
        'Leaves of Grass by Walt Whitman',
        'The Aeneid by Virgil',
        'Candide by Voltaire'
      ];

      // array of associative arrays
      $book_list =[];

      //loop through the tmp array to fill the book list
      foreach ($data as $info)
      {
        $book_info = explode(' by ', $info);
        $author_names = explode( ' ', $book_info[1]);
        $author = join(" ", array_reverse($author_names));
        $book_list[]= [
          'title' => $book_info[0],
          'author'=> $author
        ];
      }
        return $book_list;
    }
}
