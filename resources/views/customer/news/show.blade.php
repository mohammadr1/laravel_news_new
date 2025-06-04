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
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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

                    <div class="news-body justify-text">
                        {!! preg_replace('/<figcaption[^>]*>.*?<\/figcaption>/is', '' , $news->body) !!}
                    </div>
                </div>
                {{-- <section class="feedback-section">
                    <div class="feedback-box">
                        <div class="feedback-image-wrapper">

                        </div>
                    </div>
                </section> --}}
            </div>
        </section>


        
        <section class="feedback-section shadow p-4 rounded bg-white mt-3">
            <div class="feedback-box">

                @php
                $shortUrl = route('short.redirect', ['code' => $news->short_link]);
                @endphp

                <div>
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
        <section class="feedback-section shadow p-4 rounded bg-white mt-3">
            <div class="feedback-box">
                <h5 class="mb-3 font-bold text-gray-800">برچسب‌ها</h5>
                @if($news->tags && $news->tags->count())
                <div class="flex flex-wrap gap-2">
                    @foreach ($news->tags as $tag)
                    <a href="{{ route('customer.tags.show', $tag->id) }}"
                    class="tag-item bg-blue-100 cursor-pointer text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">بدون برچسب</p>
                @endif
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
                    <div class="bg-white rounded p-4 mb-4 border">
                        <section class="row">
                            <span class="border-start"></span>
                            <h3 class="h5 fw-bold text-dark mb-3 border-start border-4 border-danger pe-2">اوقات شرعی
                                امروز <span id="location-name">(در حال دریافت...)</span></h3>
                        </section>
                        {{-- @if($times) --}}
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    اذان صبح
                                    <i class="bi bi-info-circle text-primary ms-2" data-bs-toggle="tooltip"
                                        title="پیشنهاد می‌شود ۱۰ دقیقه بعد از وقت اذان نماز اقامه شود"></i>
                                </span>
                                <span id="fajr">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                طلوع آفتاب
                                <span id="sunrise">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                اذان ظهر
                                <span id="dhuhr">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                اذان مغرب
                                <span id="maghrib">--:--</span>
                            </li>
                            <p id="prayer-times-error" class="text-danger mt-3 d-none">سرویس اوقات شرعی در حال حاضر در
                                دسترس نیست.</p>

                        </ul>
                    </div>
                </section>


            </div>


        </div>
    </div>




    @endsection

    @section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const khorasanCities = [{
                    nameFa: "بجنورد",
                    nameEn: "Bojnord",
                    lat: 37.4747,
                    lon: 57.3310
                },
                {
                    nameFa: "شیروان",
                    nameEn: "Shirvan",
                    lat: 37.4092,
                    lon: 57.9276
                },
                {
                    nameFa: "اسفراین",
                    nameEn: "Esfarayen",
                    lat: 37.0700,
                    lon: 57.5100
                },
                {
                    nameFa: "جاجرم",
                    nameEn: "Jajarm",
                    lat: 36.9500,
                    lon: 56.3800
                },
                {
                    nameFa: "مانه و سملقان",
                    nameEn: "Maneh va Samalqan",
                    lat: 37.65,
                    lon: 56.73
                },
                {
                    nameFa: "گرمه",
                    nameEn: "Garmeh",
                    lat: 37.2000,
                    lon: 56.2800
                },
                {
                    nameFa: "راز و جرگلان",
                    nameEn: "Raz va Jargalan",
                    lat: 38.0700,
                    lon: 56.3800
                }
            ];

            function getNearestCity(lat, lon) {
                function getDistance(c1, c2) {
                    const toRad = x => x * Math.PI / 180;
                    const R = 6371;
                    const dLat = toRad(c2.lat - c1.lat);
                    const dLon = toRad(c2.lon - c1.lon);
                    const a = Math.sin(dLat / 2) ** 2 +
                        Math.cos(toRad(c1.lat)) * Math.cos(toRad(c2.lat)) *
                        Math.sin(dLon / 2) ** 2;
                    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                }

                let nearest = khorasanCities[0];
                let minDist = Infinity;

                for (const city of khorasanCities) {
                    const dist = getDistance({
                        lat,
                        lon
                    }, city);
                    if (dist < minDist) {
                        minDist = dist;
                        nearest = city;
                    }
                }

                return nearest;
            }

            function fetchPrayerTimes(city) {
                document.getElementById("location-name").textContent = city.nameFa;

                fetch(`https://api.aladhan.com/v1/timings?latitude=${city.lat}&longitude=${city.lon}&method=7`)
                    .then(res => res.json())
                    .then(data => {
                        const timings = data.data.timings;
                        document.getElementById("fajr").textContent = timings.Fajr;
                        document.getElementById("sunrise").textContent = timings.Sunrise;
                        document.getElementById("dhuhr").textContent = timings.Dhuhr;
                        document.getElementById("maghrib").textContent = timings.Maghrib;
                    })
                    .catch(err => {
                        console.error("خطا در دریافت اوقات شرعی:", err);
                        document.getElementById("prayer-times-error").classList.remove("d-none");
                    });
            }

            navigator.geolocation.getCurrentPosition(
                pos => {
                    const {
                        latitude,
                        longitude
                    } = pos.coords;
                    const nearestCity = getNearestCity(latitude, longitude);
                    fetchPrayerTimes(nearestCity);
                },
                err => {
                    const defaultCity = khorasanCities.find(c => c.nameEn === "Bojnord");
                    fetchPrayerTimes(defaultCity);
                }
            );

            // const defaultCity = khorasanCities.find(c => c.nameEn === "Bojnord");
            // fetchPrayerTimes(defaultCity);

            // فعال‌سازی تولتیپ‌ها بعد از بارگذاری کامل
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(el => {
                new bootstrap.Tooltip(el);
            });
        });

    </script>

    @endsection
