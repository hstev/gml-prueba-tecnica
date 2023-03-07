<?php

namespace App\Http\Controllers;

use App\Models\Category;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }
}
