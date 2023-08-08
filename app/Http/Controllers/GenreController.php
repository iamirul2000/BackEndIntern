<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Book;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::all();

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
            'name'=>'required',
        ]);

        return Genre::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Genre::find($id);
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
        $genre = Genre::find($id);
        $genre->update($request->all());
        return $genre;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Genre::destroy($id);
    }


    //Searching
    public function search($name)
    {
        return response()->json(Genre::where('name','like','%'.$name.'%')->get());

    }

    //Genres
    public function getGenreswithBooks()
    {
        $genres = Genre::with('books')->get();

        return response()->json([
            'success' => true,
            'data' => $genres
        ]);
    }

    public function getGenrewithBooks($genres)
    {
        $genres = Genre::where('id', $genres)
                  //->orWhere('name', $genres)
                  ->firstOrFail();

        $books = $genres->books()->get();

        return response()->json([
            'name' => $genres->name,
            'books' => $books,
        ]);
    }
}
