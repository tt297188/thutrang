<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function user($name)
    {
        return view('user', ['name' => $name]);  // view {{ $name }}
    }
}