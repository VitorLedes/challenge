<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    
    public function scopeSearch($query, $request)
    {
        $query->from('loans as l')
            ->join('users as u', 'l.user_id', '=', 'u.id')
            ->join('books as b', 'l.book_id', '=', 'b.id')
            ->join('loan_statuses as ls', 'l.status_id', '=', 'ls.id')
            ->orderBy('l.id', 'desc')
            ->select('l.*', 'u.name as user_name', 'u.email as user_email', 'b.title as book_title', 'b.author as book_author', 'ls.name as status_name');

        if ($request->book_search) {
            $query->where('b.title', 'like', "%$request->book_search%")
                ->orWhere('b.author', 'like', "%$request->book_search%");
        }

        if ($request->user_search) {
            $query->where('u.name', 'like', "%$request->user_search%")
                ->orWhere('u.email', 'like', "%$request->user_search%");
        }

        if ($request->status_id) {
            $query->where('l.status_id', $request->status_id);
        }

        return $query;
    }

}
