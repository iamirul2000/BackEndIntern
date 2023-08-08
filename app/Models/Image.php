<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'filename', 'extension'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // public function setPathAttribute($value)
    // {
    //     $this->attributes['path'] = $value;
    //     $this->attributes['filename'] = basename($value);

    //     // Set the desired path
    //     $path = 'images/';
    //     $this->attributes['path'] = $path . $this->attributes['filename'];
    // }

    public function getUrlAttribute()
    {
        return asset('images/' . $this->filename);
    }
}
