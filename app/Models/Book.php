<?php

namespace App\Models;

use App\BookStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function scopeSearch($query, $request)
    {
        $query->from('books')
              ->join('book_statuses', 'books.status_id', '=', 'book_statuses.id')
              ->join('genres', 'books.genre_id', '=', 'genres.id')
              ->orderBy('books.id', 'desc')
              ->select('books.*', 'book_statuses.name as status_name', 'genres.name as genre_name');
        
        if ($request->search) {
                $query->where('title', 'like', "%$request->search%")
                ->orWhere('author', 'like', "%$request->search%");
        }

        if ($request->status_id) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->genre_id) {
            $query->where('genre_id', $request->genre_id);
        }

        return $query;
    }

    public function scopeGetAvailableBooks($query, $loan = null) {
        $query->from('books as b')
              ->join('book_statuses as bs', 'b.status_id', '=', 'bs.id')
              ->where('bs.id', BookStatusEnum::AVAILABLE);

        if ($loan && $loan->book_id) {
            $query->orWhere('b.id', '=', $loan->book_id);
        }

        $query->orderBy('b.title', 'asc')
            ->select('b.*');

        return $query;
    }

}
