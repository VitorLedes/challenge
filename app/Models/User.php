<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function scopeSearch($query, $request)
    {
        $query->from('users')
            ->orderBy('id', 'desc')
            ->select('users.*');

        if ($request->search) {
            $query->where('name', 'like', "%$request->search%")
                ->orWhere('email', 'like', "%$request->search%");
        }

        return $query;
    }

}
