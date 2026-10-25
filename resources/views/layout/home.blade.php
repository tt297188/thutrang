@extends('layouts.app')

@section('title', 'Trang chủ - TechBlog')

@section('content')

    <section class="banner">
        <p class="category">CÔNG NGHỆ</p>

        <h1>Công nghệ thay đổi cuộc sống như thế nào?</h1>

        <p>Khám phá những xu hướng công nghệ mới nhất hiện nay.</p>

        <a href="#bai-viet" class="btn">Đọc bài viết</a>
    </section>

    <h2 id="bai-viet">Bài viết mới nhất</h2>

    <div class="layout">

        <section class="posts">

            @forelse ($posts as $post)

                <article class="post">

                    <img src="{{ $post['image'] }}"
                         alt="{{ $post['title'] }}">

                    <div class="post-content">

                        <p class="category">
                            {{ $post['category'] }}
                        </p>

                        <h3>{{ $post['title'] }}</h3>

                        <p>{{ $post['description'] }}</p>

                        <small>{{ $post['date'] }}</small>

                    </div>

                </article>

            @empty

                <p>Chưa có bài viết nào.</p>

            @endforelse

        </section>

        <aside class="sidebar">

            <h2>Bài viết phổ biến</h2>

            <ul>
                <li>Học lập trình PHP cho người mới</li>
                <li>Kỹ năng cần có của sinh viên IT</li>
                <li>Cách học tập hiệu quả mỗi ngày</li>
            </ul>

            <h2>Danh mục</h2>

            <p id="cong-nghe">Công nghệ</p>
            <p id="hoc-tap">Học tập</p>
            <p id="doi-song">Đời sống</p>

        </aside>

    </div>

@endsection