
<div class="container-fluid">
    @if($setting->logo_type == 'image')
        <a class="navbar-brand" href="{{ env('APP_URL') }}">
            <img src="{{ env('APP_URL') . '/storage/' . $setting->logo_image }}" alt="لوگو" class="navbar-logo">
        </a>
    @else
        <a class="navbar-brand" href="{{ env('APP_URL') }}">
            <p>{{ $setting->logo_text }}</p>
        </a>
    @endif

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="تبدیل ناوبری">
        <span class="navbar-toggler-icon"></span>
    </button>



    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">خانه</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">سیاسی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">فرهنگی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">ورزشی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">اجتماعی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">اقتصادی</a>
            </li>
        </ul>
        <form class="d-flex ms-auto" role="search">
            <input class="form-control me-2" type="search" placeholder="جستجو..." aria-label="جستجو">
            <button class="btn btn-outline-light" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
