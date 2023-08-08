<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'pages' => 'required',
            'author' => 'required',
            'publishedDate' => 'required',
            'genre_id' => 'required',
        ]);

        $book = Book::create($request->except('file'));

        $image = $request->file('file');
        $filename = time() . '_' . $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename);
    
        $image = new Image;
        $image->book_id = $book->id;
        $image->filename = ('images/' . $filename);
        $image->extension = $extension;
        $image->save();

        return response()->json($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::find($id);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Book::destroy($id);
    }

    /**
     * Searching
     */
    public function search($title)
    {
        return response()->json(Book::where('title','like','%'.$title.'%')->get());
    }

    //Books Functions
    public function getRecentlyAddedBooks()
    {
        $books = Book::orderBy('created_at', 'desc')->get();
        return response()->json($books);
    }

    public function getBookList()
    {
        $books = Book::with('genres')->orderBy('created_at', 'desc')->get();
        return response()->json($books);
    }


    //Reviews Functions
    public function getBookswithReviews()
    {
        $books = Book::with('reviews')->get();
        return response()->json($books);
    }


    //Genres Functions
    public function getGenreName($bookId)
    {
        $book = Book::find($bookId);

        if (!$book) {
            return null;
        }

        $genre = Genre::find($book->genre_id);

        if (!$genre) {
            return null;
        }

        return $genre->name;
    }

    public function getBookDetails($bookId)
    {
        $book = Book::find($bookId);

        if (!$book) {
            return null;
        }

        $genre = Genre::find($book->genre_id);

        if (!$genre) {
            return null;
        }

        return [
            'title' => $book->title,
            'description' => $book->description,
            'pages' => $book->pages,
            'author' => $book->author,
            'publishedDate' => $book->publishedDate,
            'genre' => $genre->name
        ];
    }

    public function searchBooksByGenreName($genreName)
    {
        $books = Book::join('genres', 'genres.id', '=', 'books.genre_id')
                    ->where('genres.name', 'like', '%'.$genreName.'%')
                    ->get();

        return response()->json($books);
    }
}
