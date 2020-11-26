**[Test the BookShelf online](http://the-bookshelf-lm4649.herokuapp.com/)**

## About The BookShelf

The BookShelf is a book list web application including the following functions:

- Add a book to the list
- Delete a book from the list
- Change authors name
- Search for a book by title or author
- Export in CSV and XML:
  - A list with title and author
  - A list with only titles
  - A list with only authors
  
 ## Stack
 
  - Framework: Laravel 8
  - Front-End libraries and assets: Bootstrap 4 and Font Awesome
  - Databe engine: PostgreSQL
  
## How to deploy
  
### Local environment 

  [Check here](https://laravel.com/docs/8.x/installation) the prerequisites for running Laravel 8 on your computer.
 
 Clone and pull the repo
 Change '.env.example' file to '.env' and setup your database info from line 10 to 15
 Run the server (php artisan serve)
 Run the migration (php artisan migrate)
 Run the Book seeder (php artisan db:seed --class=BookSeeder)
  
  ***Attention points:***
  - In 'config\database.php', line 5 ($DATABASE_URL=...) shall be commented
  - To use mySQL instead of PostgreSQL, in 'config\database.php', line 20 (default database connection name), replace 'pgsql' by 'mysql'
  
### Production environment

#### Heroku

  [Click here](https://devcenter.heroku.com/articles/getting-started-with-laravel) to check how to deploy a laravel application on Heroku.
    
   Or [click here](https://dev.to/jsafe00/deploy-laravel-application-with-database-to-heroku-l50) to check how to deploy it **with a pgsl database**.
  
  [How to deploy it with a mysql database](https://salitha94.blogspot.com/2019/11/deploy-laravel-application-on-heroku.html)
  
  ***Attention points:***
  - In 'config\database.php', line 5 ($DATABASE_URL=...) shall **not** be commented
  - In 'resources\views\app.blade.php', lines 8 and 10, load script and stylesheet turn 'asset()' to 'secure_asset()
  - In 'public\fonts' directory, do not remove the '.htaccess' file.

 
