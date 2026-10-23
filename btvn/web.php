<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $posts = [
        [
            'title' => 'Học lập trình PHP từ cơ bản',
            'category' => 'Học tập',
            'description' => 'Bắt đầu học PHP dành cho sinh viên mới.',
            'date' => '23/10/2026',
            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600'
        ],
        [
            'title' => 'Xu hướng công nghệ hiện nay',
            'category' => 'Công nghệ',
            'description' => 'Tìm hiểu những công nghệ đang phát triển.',
            'date' => '22/10/2026',
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600'
        ],
        [
            'title' => 'Bí quyết học tập hiệu quả',
            'category' => 'Học tập',
            'description' => 'Sắp xếp thời gian để học tốt hơn.',
            'date' => '21/10/2026',
            'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600'
        ],
        [
            'title' => 'Khám phá thế giới số',
            'category' => 'Đời sống',
            'description' => 'Công nghệ trong cuộc sống hàng ngày.',
            'date' => '20/10/2026',
            'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600'
        ]
    ];

    return view('home', compact('posts'));
});