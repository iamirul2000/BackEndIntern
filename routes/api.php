<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Public Routes
//Users
Route::get('/users',[UserController::class, 'index']);
Route::get('/users/{id}',[UserController::class, 'show']);
Route::get('/users/search/{name}', [UserController::class, 'search']);

//Books
Route::get('/books',[BookController::class, 'index']); //Shows all books details without genre name
Route::get('/books/{id}',[BookController::class, 'show']); //Shows books details based on id (user click on a book page)
Route::get('/booksReviews', [BookController::class, 'getBookswithReviews']); //Shows books details and its reviews (all)
Route::get('/books/search/{title}', [BookController::class, 'search']); //Search books based on title
Route::get('/getGenrename/{bookId}', [BookController::class, 'getGenreName']); //Display genre name based on books id
Route::get('/booksDetails/{bookId}', [BookController::class, 'getBookDetails']); //Show books details based on id with Genre
Route::get('/booksList', [BookController::class, 'getBookList']); //Shows all books details with genre name
Route::get('/recentlyAddedBooks', [BookController::class, 'getRecentlyAddedBooks']); // Show details of recently added books but no genre name
Route::get('/searchBooksByGenre/{genreName}', [BookController::class, 'searchBooksByGenreName']); //Shwos books by searched genre
Route::get('/booksImage/{id}', [ImageController::class, 'show']); //Show book image,genre and details

//Genres
Route::get('/genres',[GenreController::class, 'index']);
Route::get('/genres/{id}',[GenreController::class, 'show']);
Route::get('/genres/search/{name}', [GenreController::class, 'search']);
Route::get('/genresBooks', [GenreController::class, 'getGenreswithBooks']);
Route::get('/genres/genreWbooks/{genres}', [GenreController::class, 'getGenrewithBooks']);

//Reviews
Route::resource('reviews',ReviewController::class);
Route::get('/bookReview/{bookId}', [ReviewController::class, 'getBookReview']);

//Register Admin
Route::post('/register', [AuthController::class, 'register']);

//Login
Route::post('/login', [AuthController::class, 'login']);

//Protected Routes
Route::group([ 'middleware' => ['auth:sanctum']], function() {
    //Users Route
    Route::post('/users',[UserController::class, 'store']);
    Route::put('/users/{id}',[UserController::class, 'update']);
    Route::delete('/users/{id}',[UserController::class, 'destroy']);

    //Books Route
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}',[BookController::class, 'update']);
    Route::delete('/books/{id}',[BookController::class, 'destroy']);

    //Genres Route
    Route::post('/genres',[GenreController::class, 'store']);
    Route::put('/genres/{id}',[GenreController::class, 'update']);
    Route::delete('/genres/{id}',[GenreController::class, 'destroy']);

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);

});

//Examples
//Route::resource('users',UserController::class);
//Route::resource('books',BookController::class);
//Route::resource('genres',GenreController::class);