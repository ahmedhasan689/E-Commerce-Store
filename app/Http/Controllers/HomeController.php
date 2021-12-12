<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->limit(8)->get();
        return view('home', compact('products'));
    }

    public function getUser()
    {
        $users = User::with('profile')->get();
        foreach($users as $user) {
            echo $user->profile->created_at;
        }
    }



}
