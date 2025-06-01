@extends('customer.layouts.master-one-col')

@section('head-tag')

@endsection

@section('content')

<div class="row g-3 align-items-stretch">
    <!-- اسلایدر -->
    <div class="col-md-8">
        <div class="position-relative shadow rounded overflow-hidden" style="height: 350px;">
            <div id="myCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    @foreach($sliders as $index => $slider)
                    <a href="{{ route('customer.news.show', $slider) }}">
                        <div class="carousel-item h-100 @if($index === 0) active @endif">
                            <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100 h-100"
                                alt="{{ $slider->title }}" style="object-fit: cover;">
                            <div class="position-absolute bottom-0 w-100 p-3" style="
                            background-color: rgba(0,0,0,0.6);
                            color: white;
                            max-height: 45%;
                            overflow: auto;
                            font-size: 0.9rem;
                            direction: rtl;
                            border-top-left-radius: 10px;
                            border-top-right-radius: 10px;">
                                <h5 class="mb-2">{{ $slider->title }}</h5>
                                @if($slider->publish_date)
                                <p class="mb-1">{{ jdate($slider->publish_date)->format('j F Y') }}</p>
                                @endif
                                @if($slider->subtitle)
                                <p class="mb-0" style="word-wrap: break-word;">{{ $slider->subtitle }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- کنترل‌ها -->
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">قبلی</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">بعدی</span>
                </button>
            </div>
        </div>
    </div>
    {{-- news items next to the slider --}}
    <div class="col-12 col-md-4">
        <div class="d-flex flex-column" style="height: 350px;">
            @foreach ($leftSliderNews as $news)
            <div class="news-card d-flex shadow-sm rounded bg-white mb-2" style="height: 50%; overflow: hidden;">
                <div class="w-50 p-2">
                    <a href="{{ route('customer.news.show', $news) }}">
                        <img src="{{ asset('storage/' . $news->image) }}"
                            class="img-fluid rounded w-100 h-100 object-fit-cover" alt="خبر">
                    </a>
                </div>
                <div class="w-50 p-2 d-flex flex-column justify-content-between overflow-auto">
                    <div>
                        <span class="badge bg-danger mb-1">{{ $news->category->title }}</span>
                        <h6 class="news-title mb-1 small"><a class="text-black"
                                href="{{ route('customer.news.show', $news) }}">{{ $news->title }}</a></h6>
                        <div class="news-meta small text-muted">
                            <span><i
                                    class="far fa-clock me-1"></i>{{ jdate($news->published_at)->format('Y/m/d') }}</span><br>
                            <span><i class="far fa-user me-1"></i>{{ $news->author->name ?? 'نامشخص' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- اگر فقط یک خبر وجود دارد، جای خالی را پر کن --}}
            @if ($leftSliderNews->count() == 1)
            <div class="news-card d-flex shadow-sm rounded bg-light mb-2" style="height: 50%; opacity: 0.3;">
                {{-- <div class="w-100 d-flex justify-content-center align-items-center text-muted">
                        <span>خبر دیگری موجود نیست</span>
                    </div> --}}
            </div>
            @endif
        </div>
    </div>


</div>


<div class="row mt-3 shadow">
    <div class="col-md-8 rounded " style="height: auto;">
        <h3 class="text-right mb-4 p-2"><i class="fas fa-newspaper me-2"></i>آخرین اخبار</h3>

        @foreach ($bottomSliderNews as $news)
        <div class="news-card row align-items-center shadow-sm rounded-3 p-3 mb-4 bg-white">
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid rounded-3 shadow-sm" alt="تصویر خبر">
            </div>
            <div class="col-md-8">
                <a href="{{ route('customer.news.show', $news) }}">
                    <div class="news-content">
                        <span class="badge bg-danger mb-2">فوری</span>
                        <h5 class="news-title text-dark">{{ $news->title }}</h5>
                        <p class="text-black">
                            {{ Str::limit(trim(str_replace('&nbsp;', ' ', strip_tags($news->body))), 150, '[...]') }}
                        </p>
                        <div class="news-meta mt-3">
                            <span class="news-date text-muted">
                                <i class="far fa-clock me-1"></i> {{ jdate($news->published_at)->format('Y/m/d') }}
                            </span>
                            <span class="news-author text-muted ms-3">
                                <i class="far fa-user me-1"></i> نویسنده: {{ $news->author->name ?? 'نامشخص' }}
                            </span>
                        </div>
                        {{-- <a href="{{ route('news.show', $news->slug) }}" class="btn btn-sm btn-primary mt-3">مشاهده
                        کامل
                        خبر
                </a> --}}
            </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- بخش کناری -->
<div class="col-md-4  rounded" style="max-width: 800px; height: auto;">
    <section class="feedback-section">

        @foreach($messages as $message)
        <div class="feedback-box">
            <div class="user-message">
                <h3>حرف مردم</h3>
                <p>{{ $message->content }}</p>
            </div>
            <div class="admin-response">
                <h4>پاسخ مسئول</h4>
                <p>{{ $message->response }}</p>
            </div>
        </div>
        @endforeach


    </section>

</div>


</div>

<section class="media-section">
    @if($media->media_type === 'image')
    <img src="{{ asset('storage/' . $dailyMedia->media_path) }}" alt="{{ $dailyMedia->title }}">
    <!-- تصویر -->
    <div class="media-box">
        <div class="media-header">تصویر شاخص روز</div>
        <div class="media-content">
            <img src="{{ asset('storage/' . $dailyMedia->media_path) }}" alt="{{ $dailyMedia->title }}">
            {{-- <img src="{{ asset('assets/img/test.jpg') }}" alt="تصویر نمونه"> --}}
        </div>
    </div>
@endif
    <!-- ویدیو -->
    <div class="media-box">
        <div class="media-header">ویدیو شاخص روز</div>
        <div class="media-content">
            <video controls>
                <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
            </video>
        </div>
    </div>
</section>






{{-- start pishnehadi --}}

@if($media)
    <div class="daily-media">
        <h2>{{ $media->title }}</h2>
        <p>{{ $media->lead }}</p>

        @if($media->media_type === 'image')
            <img src="{{ asset('storage/' . $media->media_path) }}" alt="{{ $media->title }}" style="max-width: 100%;">
        @elseif($media->media_type === 'video')
            @if(Str::startsWith($media->media_path, ['http', 'https']))
                {{-- ویدیو از لینک خارجی (یوتیوب، آپارات و...) --}}
                <div class="video-wrapper">
                    <iframe
                        src="{{ convertToEmbed($media->media_path) }}"
                        frameborder="0"
                        allowfullscreen
                        style="width: 100%; aspect-ratio: 16/9;">
                    </iframe>
                </div>
            @else
                {{-- ویدیو آپلودی --}}
                <video controls style="max-width: 100%;">
                    <source src="{{ asset('storage/' . $media->media_path) }}" type="video/mp4">
                    مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                </video>
            @endif
        @endif
    </div>
@endif

{{-- end pishnehadi --}}










<style>
    .media-section {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        align-items: stretch;
        margin-top: 20px;
    }

    .media-box {
        flex: 1 1 45%;
        background-color: white;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .media-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .media-header {
        /* padding: 1rem; */
        font-size: 1.4rem;
        font-weight: bold;
        background-color: #eef2f7;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .media-content {
        /* padding: 1rem; */
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 250px;
    }

    .media-content img,
    .media-content video {
        max-width: 100%;
        max-height: 200px;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .media-box {
            flex: 1 1 100%;
        }
    }

</style>

<style>
    .news-title {
        font-size: 1rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .news-meta span {
        font-size: 0.8rem;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    @media (max-width: 576px) {
        .news-card h6 {
            font-size: 0.95rem;
        }

        .news-card .btn {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }

        .carousel-caption {
            font-size: 0.9rem;
            padding: 0.5rem;
        }
    }

</style>


@endsection
