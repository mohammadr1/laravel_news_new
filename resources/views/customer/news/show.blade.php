@extends('customer.layouts.master-one-col')

@section('head-tag')
<link rel="stylesheet" href="{{ asset('assets/css/style-show.css') }}">

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
{{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
</style> --}}

@endsection

@section('content')

<div class="custom-responsive-row col-12 row">

    <div class="col-md-8 rounded" style="max-width: 800px; height: auto;">

        <section class="feedback-section shadow">
            <div class="feedback-box">
                <div class="feedback-image-wrapper">
                    <img src="{{ asset('storage/' . $news->image) }}" class="feedback-image" alt="{{ $news->title }}">
                </div>
                <div class="d-flex flex-wrap align-items-center text-muted mb-4 pb-3 border-bottom small">
                    <div class="me-4 mb-2">
                        <i class="far fa-calendar me-1"></i>
                        <span>۱۵ مرداد ۱۴۰۲</span>
                    </div>
                    <div class="me-4 mb-2">
                        <i class="far fa-clock me-1"></i>
                        <span>۱۴:۳۰</span>
                    </div>
                    <div class="mb-2">
                        <i class="far fa-eye me-1"></i>
                        <span>{{ $news->views }} بازدید</span>
                    </div>
                </div>

                <div class="feedback-content p-2">
                    <span class="news-pretitle">{{ $news->on_titr }}</span>
                    <h1 class="news-title">{{ $news->title }}</h1>
                    <p class="news-subtitle">{{ $news->subtitle }}</p>

                    <p class="news-body text-justify">{!! $news->body !!}</p>
                </div>
                <section class="feedback-section">
                    <div class="feedback-box">
                        <div class="feedback-image-wrapper">

                        </div>
                    </div>
                </section>
            </div>
        </section>

        <section class="feedback-section shadow">
            <div class="feedback-box-link">

                @php
                $shortUrl = route('short.redirect', ['code' => $news->short_link]);
                @endphp

                <div style="margin-top: 16px;">
                    <h5>لینک کوتاه خبر</h3>
                        <section>
                            <small id="copyMessage" style="margin-left: 10px; color: green; display: none;">کپی شد
                                ✅</small>
                            <span id="shortLinkText"
                                style="color: #007bff; cursor: pointer; direction: ltr; float: left;"
                                onclick="copyShortLink()">
                                {{ $shortUrl }}
                            </span>
                        </section>
                </div>


                <script>
                    function copyShortLink() {
                        const text = document.getElementById("shortLinkText").innerText;

                        navigator.clipboard.writeText(text).then(function () {
                            const msg = document.getElementById("copyMessage");
                            msg.style.display = "inline";
                            setTimeout(() => msg.style.display = "none", 2000);
                        }).catch(function (err) {
                            alert("خطا در کپی کردن لینک!");
                        });
                    }

                </script>


            </div>
        </section>

        <section class="feedback-section shadow">
            <div class="feedback-box-link">
                <h5>برچسب‌ها</h3>
                    {{ is_array($news->tags) ? implode('، ', $news->tags) : $news->tags }}
            </div>
        </section>

    </div>

    <!-- Sidebar -->
    <div class="col-lg-4 col-md-5 col-sm-12 mb-3 rounded" style="max-width: 800px;">
        <div class="sticky-top" style="top: 120px;">
            <div class="box-container ">
                <section class="mb-4 shadow-sm">
                    <div class="bg-white rounded p-4 mb-4 border">
                        <section class="row">
                            <span class="border-start"></span>
                            <h3 class="h5 fw-bold text-dark mb-3 border-start border-4 border-danger pe-2">دسته‌بندی‌ها
                            </h3>
                        </section>
                        <ul class="list-unstyled">
                            @foreach ($categories as $category)
                            <li class="border-bottom">
                                <a href="#"
                                    class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark hover-blue">
                                    <span>{{ $category->title }}</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 small">
                                        {{ $category->news_count }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </section>


                <section class="mb-4 shadow-sm">

                </section>

            </div>


        </div>
    </div>




    @endsection
