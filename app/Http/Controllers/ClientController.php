<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        return view('client.index', compact('categories'));
    }

}
