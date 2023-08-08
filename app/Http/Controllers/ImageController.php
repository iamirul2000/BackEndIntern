<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function uploadImage(Request $request, $id)
    {
        $book = Book::find($id);

        $image = $request->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename);
    
        $image = new Image;
        $image->book_id = $book->id;
        $image->filename = $filename;
        $image->extension = $extension;
        $image->save();

        return response()->json(['message' => 'Image uploaded successfully'], 200);
    }

    public function show($id)
    {
        $book = Book::with('genres')->find($id);
        $images = Image::select('filename')->where('book_id', $id)->get();

        return response()->json([
            'book' => $book,
            'images' => $images,
        ]);
    }
}
