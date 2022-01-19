<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
    }

    public function index() 
    {
        return view('chat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);



        broadcast(new MessageSent($request->message, Auth::user()));

        return;
    }
}
