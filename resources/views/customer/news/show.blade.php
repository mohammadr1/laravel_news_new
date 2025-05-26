@extends('customer.layouts.master-one-col')

@section('head-tag')
<link rel="stylesheet" href="{{ asset('assets/css/style-show.css') }}">
@endsection

@section('content')

<div class="col-md-8 rounded" style="max-width: 800px; height: auto;">
    <section class="feedback-section shadow">
        <div class="feedback-box">
            <div class="feedback-image-wrapper">
                <img src="{{ asset('storage/' . $news->image) }}" class="feedback-image" alt="{{ $news->title }}">
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
</div>

<div class="col-md-8 rounded mt-2" style="max-width: 800px; height: auto;">
    <section class="feedback-section shadow">
        <div class="feedback-box-link">


            <div class="related-news-box"
                style="padding: 16px; margin-top: 24px; background-color: #f9f9f9; direction: rtl;">
                <h4 style="margin-bottom: 12px; font-size: 18px; color: #333;">🔗 لینک خبر</h4>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span id="newsLink" style="color: #007bff; cursor: pointer;"
                        onclick="copyLink()">{{ request()->url() }}</span>
                    <span id="copyMessage" style="color: green; font-size: 14px; display: none;">لینک کپی شد ✅</span>
                </div>
            </div>

            <script>
                function copyLink() {
                    const linkText = document.getElementById("newsLink").innerText;
                    navigator.clipboard.writeText(linkText).then(() => {
                        const message = document.getElementById("copyMessage");
                        message.style.display = "inline";
                        setTimeout(() => {
                            message.style.display = "none";
                        }, 2000);
                    });
                }

            </script>


        </div>
    </section>
</div>
@endsection
