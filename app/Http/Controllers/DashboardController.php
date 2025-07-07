<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $data = [
            'availableBooks' => '',
            'borrowedBooks' => '',
        ];

        return view('dashboard.index', $data);
    }
}
