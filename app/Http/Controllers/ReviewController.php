<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Review::all();
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
            'comment' => 'required',
            'rate' => 'required',
            'book_id' => 'required',
        ]);

        return Review::create($request->all());
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Review::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $book_id)
    {
        $book = Book::find($book_id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $review = $book->reviews()->find($review_id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $data = $request->validate([
            'comment' => 'required|string|max:255',
            'rate' => 'required|integer|min:1|max:5',
            'book_id' => 'required',
        ]);

        $review->update($data);

        return response()->json(['review' => $review], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Review::destroy($id);
    }


    public function getBookReview($bookId)
    {
        $book = Book::with('reviews')->findOrFail($bookId);

        return response()->json($book);
    }
}
