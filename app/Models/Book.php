<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pages',
        'author',
        'publishedDate',
        'genre_id',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function genres()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getUrlAttribute()
    {
        return asset('images/' . $this->filename);
    }
}
