<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Trang chủ blog PHP';

        return view('home', ['title' => $title]); // compact('title')
    }

    public function search(Request $request)
    {
        var_dump($request->input('text', 'tungpn'));
    }
}