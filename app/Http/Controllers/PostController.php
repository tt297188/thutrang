<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Trang chủ hiển thị danh sách tất cả bài viết
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('home', compact('posts'));
    }

    // Xem chi tiết bài viết
    public function show(Post $post)
    {
        // Nạp thêm thông tin comment kèm theo bài viết
        $post->load('comments');
        return view('post_show', compact('post'));
    }
}