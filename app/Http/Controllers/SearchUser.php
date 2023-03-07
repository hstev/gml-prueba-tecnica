<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchUser extends Controller
{
    public function index(Request $request)
    {
        $text = $request->text;

        return User::where('users.name', $text)
        ->orWhere('users.last_name', $text)
        ->orWhere('categories.name', $text)
        ->orWhere('users.document', $text)
        ->orWhere('users.email', $text)
        ->orWhere('users.address', $text)
        ->orWhere('users.phone_number', $text)
        ->orWhere('users.country', $text)
        ->join('categories', 'categories.id', '=', 'users.category_id')
        ->with('category')
        ->get();        
    }    
}
