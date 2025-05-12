<!doctype html>
<html lang="ar" dir="rtl" data-bs-theme="auto">

<head>

    @include('customer.layouts.head-tag')
    @yield('head-tag')

</head>

<body>

    @include('customer.layouts.theme')

    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top">
            @include('customer.layouts.header')
        </nav>
    </header>



    <main>
        <div class="container">

            @yield('content')
            
        </div>
    </main>



    <!-- FOOTER -->
    <footer class="footer pt-4 pb-2 mt-5">
        <div class="container">
            @include('customer.layouts.footer')
        </div>
    </footer>


    </main>

    <!-- دکمه بالابر -->
    <button id="scrollToTopBtn" class="btn-scroll-top" title="بازگشت به بالا">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('customer.layouts.scripts')
</body>

</html>
