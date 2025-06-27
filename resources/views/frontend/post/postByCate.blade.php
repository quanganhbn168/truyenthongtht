@extends('layouts.master')
@section('title', $category->name)

@section('content')
<section class="section py-4">
    <div class="container">
        {{-- Breadcrumb --}}
        <x-frontend.breadcrumb :items="[
            ['label' => 'Bài viết', 'url' => route('frontend.post.postByCate', $category->slug)],
            ['label' => $category->name]
        ]" />

        <div class="row">
            {{-- Cột trái: danh sách bài viết --}}
            <div class="col-md-8">
                <h1 class="mb-4">{{ $category->name }}</h1>
                @foreach($posts as $post)
                <div class="mb-4 border-bottom pb-3 row">
                    <div class="col-md-4">
                        <a href="{{ route('frontend.post.detail', $post->slug) }}">
                            <img src="{{ asset($post->image ?? 'images/setting/no-image.png') }}" alt="{{ $post->title }}" class="img-fluid w-100" style="object-fit: cover; max-height: 180px;">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <a href="{{ route('frontend.post.detail', $post->slug) }}" class="d-block mb-2">
                            <h4 class="mb-1">{{ $post->title }}</h4>
                        </a>
                        <div class="small text-muted mb-2">
                            {{ $post->created_at->format('d/m/Y') }}
                        </div>
                        <p>{{ Str::limit(strip_tags($post->description), 150) }}</p>
                    </div>
                </div>
                @endforeach

                <div class="mt-4">
                    {{ $posts->withQueryString()->links() }}
                </div>

            </div>

            {{-- Cột phải: Sidebar --}}
            <div class="col-md-4">
                {{-- Form tìm kiếm --}}
                <div class="mb-4">
                    <form action="{{ route('frontend.post.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Tìm kiếm bài viết...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Tìm</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Danh mục bài viết --}}
                <div class="mb-4">
                    <h5>📂 Danh mục bài viết</h5>
                    <ul class="list-unstyled">
                        @foreach($allCategories as $cat)
                        <li>
                            <a href="{{ route('frontend.post.postByCate', $cat->slug) }}"
                               class="{{ $cat->id === $category->id ? 'font-weight-bold text-primary' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Gợi ý: Sản phẩm nổi bật, bài viết nổi bật, tùy mục đích --}}
                <div>
                    <h5>🔥 Bài viết nổi bật</h5>
                    <ul class="list-unstyled">
                        @foreach($featuredPosts as $post)
                        <li class="mb-2">
                            <a href="{{ route('frontend.post.detail', $post->slug) }}">{{ $post->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
