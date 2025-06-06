    <div class="col-lg-4 col-md-5 col-sm-12 rounded" style="max-width: 800px;">
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
                                <a href="{{ route('customer.category.show', $category->slug) }}"
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