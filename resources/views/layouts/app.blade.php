<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png?version=1') }}">

    <meta property='og:title' content='{{env('APP_NAME')}}'/>
    <meta property='og:image' content='{{asset('assets/thumbnail.jpg')}}'/>
    <meta property='og:description' content='{{env('APP_DESCRIPTION')}}'/>
    <meta property='og:url' content='{{env('APP_URL')}}'/>
    <meta property='og:image:width' content='1200' />
    <meta property='og:image:height' content='627' />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">


    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- 'resources/sass/app.scss', --}}
    <script src="https://kit.fontawesome.com/04e9a3dbb4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

{{-- <body>
    @php
        use App\Admin;
        use App\Models\Ui;
    @endphp
    @if (filter_var(Ui::first()->background_url, FILTER_VALIDATE_URL))
        <img id="imgBackground" src="{{ Ui::first()->background_url }}"
            style="position: fixed; top:0px; left:0px; width:100vw; object-fit:cover; height:100%; z-index:-1;">
    @endif

    <div id="app">
        <nav id="navbar" class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
            style="width:100%; padding:0px; background-image:url('{{ Ui::first()->header_url }}'); position:fixed; z-index:5000;">
            <div class="container" style="margin:10px; width:100%; max-width:10000px;">
                <img class="navbar-brand" src="{{ asset('storage/assets/logo.png') }}"
                    style="height:80px; padding:0px; cursor:pointer;" onclick="logoClicked()" />

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex justify-content-center" style="margin:auto;">
                        @guest
                        @else
                            <li class="nav-item dropdown  navbar-btn filter-element" style="background-color:#11A37F;">
                                <a id="navbarDropdown" class="nav-link  header-text d-flex justify-content-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-chart-line fa-lg header-icon"></i>&ensp;{{ __('Statistic') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        {{ __('Overal Statistic') }}
                                    </a>

                                </div>
                            </li>
                            <li class="nav-item d-flex justify-content-center navbar-btn filter-element"
                                style="background-color:#168B9F;">
                                <a class="nav-link header-text" href="{{ route('admin.product.index') }}"><i
                                        class="fa-solid fa-box fa-lg header-icon"></i>&ensp;{{ __('Product Manager') }}</a>
                            </li>

                            <li class="nav-item dropdown  navbar-btn filter-element" style="background-color:#FFBB00;">
                                <a id="navbarDropdown" class="nav-link  header-text d-flex justify-content-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-coins  fa-lg header-icon"></i>&ensp;{{ __('Cost') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN]))
                                        <a class="dropdown-item" href="{{ route('admin.cost.costsList') }}">
                                            Danh mục chi phí
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('admin.cost.index') }}">
                                        Bảng chi phí
                                    </a>


                                </div>
                            </li>

                            @if (Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN, ROLE_STAFF]))
                                <li class="nav-item dropdown  navbar-btn filter-element" style="background-color:gray;">

                                    <a id="navbarDropdown" class="nav-link  header-text d-flex justify-content-center"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" v-pre>
                                        <i class="fa-solid fa-users fa-lg header-icon"></i>&ensp;{{ __('HR Manager') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="">
                                            {{ __('Employment diagram') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.staff.staffList') }}">
                                            {{ __('Staff List') }}
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.staff.timekeeping.timeKeepingIndex') }}">
                                            {{ __('Timekeeping') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('admin.staff.salary.salaryIndex') }}">
                                            {{ __('Salary') }}
                                        </a>
                                    </div>
                                </li>
                            @endif



                            <li class="nav-item dropdown  navbar-btn filter-element" style="background-color:#AB35B1;">

                                <a id="navbarDropdown" class="nav-link  header-text  d-flex justify-content-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-receipt fa-lg header-icon"></i>&ensp; Bán hàng
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.invoice.invoiceList') }}">
                                        Quản lý đơn hàng
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.invoice.createInvoice') }}">
                                        Bán hàng
                                    </a>


                                </div>
                            </li>

                            <li class="nav-item dropdown  navbar-btn filter-element" style="background-color:#F6412E;">

                                <a id="navbarDropdown" class="nav-link  header-text  d-flex justify-content-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-bullhorn fa-lg header-icon"></i></i>&ensp; Kênh marketing
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.marketingChannel.index') }}">
                                        Chương trình khuyến mãi
                                    </a>
                                </div>
                            </li>
                            @if (Admin::user()->inRoles([ROLE_CHEF, ROLE_TECH_ADMIN]))
                                <li class="nav-item  navbar-btn filter-element" style="background-color:#00AE45;">
                                    <a class="nav-link header-text d-flex justify-content-center"
                                        href="{{ route('admin.ui.index') }}">
                                        <i class="fa-regular fa-image fa-lg header-icon"></i>&ensp;Quản lý hệ thống</a>
                                </li>
                            @endif
                        @endguest
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link header-text" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link header-text d-flex justify-content-center"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="color:black;" v-pre>
                                    {{ Auth::user()->name }}&ensp;<i
                                        class="fa-regular fa-circle-user fa-2xl header-icon"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main style="padding-top:110px; margin:auto;">
            @yield('content')
            @yield('content2')

        </main>
    </div>
</body> --}}

<body id="body-pd" style="padding:0px !important;">
    @php
        use App\Admin;
        use App\Models\Ui;
    @endphp

    <header class="header" id="header">
        <div class="header_toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        {{-- <div class="header_img"> <img class="navbar-brand" src="{{ asset('storage/assets/logo.png') }}"
            style="height:35px; padding:0px; cursor:pointer;" onclick="logoClicked()" /> </div> --}}
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                {{-- <a href="#" class="nav_logo">
                    <span class="nav_logo-name" id="name_company">{{env('APP_NAME')}}</span>
                </a> --}}
                <div class="nav_list">
                    <a href="#"  class="nav_link " onclick="toggleNav('statistic-collapse')">
                        {{-- <i class='bx bx-grid-alt nav_icon'></i> --}}
                        <i class="fa-solid fa-chart-line fa-lg nav_icon"></i>
                        <span class="nav_name">{{ __('Statistic') }}</span>
                    </a>
                    <div class="collapse nav-childs" id="statistic-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.dashboard') }}" class="nav-child rounded">{{ __('Overal Statistic') }}</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.product.index') }}" class="nav_link">
                        <i class='fa-solid fa-box fa-lg nav_icon'></i>
                        <span class="nav_name">Kho hàng</span>
                    </a>

                    <a href="{{ route('admin.invoice.createInvoice') }}" class="nav_link">
                        <i class='fa-solid fa-boxes-packing fa-lg nav_icon'></i>
                        <span class="nav_name">Bán hàng</span>
                    </a>

                    <a href="#" class="nav_link " onclick="toggleNav('financial-accounting-collapse')">
                        <i class='fa-solid fa-coins  fa-lg nav_icon'></i>
                        <span class="nav_name">Tài chính - Kế toán</span>
                    </a>
                    <div class="collapse nav-childs" id="financial-accounting-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          {{-- <li><a href="{{ route('admin.cost.costsList') }}" class="nav-child rounded">Danh mục chi phí</a></li> --}}
                          <li><a href="{{ route('admin.cost.index') }}" class="nav-child rounded">Chi phí</a></li>
                          <li><a href="{{ route('admin.invoice.invoiceList') }}" class="nav-child rounded">Quản lý đơn hàng</a></li>
                        </ul>
                    </div>

                    {{-- <a href="#" class="nav_link " onclick="toggleNav('cost-collapse')">
                        <i class='fa-solid fa-coins  fa-lg nav_icon'></i>
                        <span class="nav_name">{{ __('Cost') }}</span>
                    </a>
                    <div class="collapse nav-childs" id="cost-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.cost.costsList') }}" class="nav-child rounded">Danh mục chi phí</a></li>
                          <li><a href="{{ route('admin.cost.index') }}" class="nav-child rounded">Bảng chi phí</a></li>

                        </ul>
                    </div> --}}
                    <a href="#" class="nav_link" onclick="toggleNav('staff-collapse')">
                        <i class='fa-solid fa-users fa-lg nav_icon'></i>
                        <span class="nav_name">Hành chính - Nhân sự</span>
                    </a>
                    <div class="collapse nav-childs" id="staff-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.staff.staffTree') }}" class="nav-child rounded">{{ __('Employment diagram') }}</a></li>
                          <li><a href="{{ route('admin.staff.staffList') }}" class="nav-child rounded">{{ __('Staff List') }}</a></li>
                          <li><a href="{{ route('admin.staff.timekeeping.timeKeepingIndex') }}" class="nav-child rounded">{{ __('Timekeeping') }}</a></li>
                          <li><a href="{{ route('admin.staff.salary.salaryIndex') }}" class="nav-child rounded">{{ __('Salary') }}</a></li>

                        </ul>
                    </div>
                    {{-- <a href="#" class="nav_link" onclick="toggleNav('invoice-collapse')">
                        <i class='fa-solid fa-receipt fa-lg nav_icon'></i>
                        <span class="nav_name">Bán hàng</span>
                    </a>
                    <div class="collapse nav-childs" id="invoice-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.invoice.invoiceList') }}" class="nav-child rounded">Quản lý đơn hàng</a></li>
                          <li><a href="{{ route('admin.invoice.createInvoice') }}"class="nav-child rounded">Bán hàng</a></li>
                        </ul>
                    </div> --}}
                    <a href="#" class="nav_link"  onclick="toggleNav('marketing-collapse')">
                        <i class='fa-solid fa-bullhorn fa-lg nav_icon'></i>
                        <span class="nav_name">Kênh marketing - Bán hàng</span>
                    </a>
                    <div class="collapse nav-childs" id="marketing-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.marketingChannel.index') }}" class="nav-child rounded">Chương trình khuyến mãi</a></li>
                        </ul>
                    </div>

                    {{-- <a href="#" class="nav_link"  onclick="toggleNav('documents-collapse')">
                        <i class='fa-solid fa-folder-open fa-lg nav_icon'></i>
                        <span class="nav_name">Kho lưu trữ tài liệu</span>
                    </a>
                    <div class="collapse nav-childs" id="documents-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                          <li><a href="{{ route('admin.marketingChannel.index') }}" class="nav-child rounded">Mẫu văn bản</a></li>
                          <li><a href="{{ route('admin.marketingChannel.index') }}" class="nav-child rounded">Tài liệu công ty</a></li>

                        </ul>
                    </div> --}}
                </div>
            </div>
            <a href="{{ route('logout') }}" class="nav_link"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">Đăng xuất</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    class="d-none">
                    @csrf
                </form>
            </a>
        </nav>
    </div>
    <!--Container Main start-->
    <main class="mainSec" style="padding-top:20px;">
        @yield('content')
        @yield('content2')

    </main>

    <div class="container">
        <footer class="py-0 my-0">
            <div class="d-flex justify-content-center">
                <img src="{{asset('assets/footerlogo.png')}}" alt="footerlogo" onclick="logoClicked()">
            </div>
            <div class="d-flex justify-content-center">
                <p class="text-center text-muted" style="max-width:700px; font-size:18px;">LOTTE DEPARTMENT STORE VIETNAM</p>
            </div>
            <div class="d-flex justify-content-center">
                <p class="text-center text-muted" style="max-width:700px; font-size:13px;">© Bản quyền thuộc về công ty TNHH Lotte Shopping Plaza Việt Nam tầng 1 đến tầng 6, tòa nhà Lotte Center Hanoi,
                    54 Liễu Giai, quận Ba Đình, Hà Nội | Hotline: 024 3333 2500</p>
            </div>

        </footer>
    </div>
</body>
<script>
    const logoClicked = () => {
        window.location.href = `{{ route('home') }}`;
    }
    setInterval(function() {
        location.reload();
    }, 500000);

    function collapseAllChild(){
        $('.collapse').removeClass("show");
    }

    function toggleNav(id){
        console.log($( `#${id} `).hasClass( "show" ));
        if($( `#${id} `).hasClass( "show" )){
            console.log('remove show in sidebar : ', id);
            collapseAllChild();
            $(`#${id}`).addClass('hide');


        }else{
            console.log('add show in sidebar : ', id);
            collapseAllChild();

            $(`#${id}`).removeClass('hide');

            $(`#${id}`).addClass('show');

        }
    }

    let headerOpen = false;
    let screenWidth = screen.width;
    console.log('screen width : ', screenWidth);
    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            // Validate that all variables exist
            if (toggle && nav && bodypd && headerpd) {
                if (screenWidth <= 768) {
                    toggle.addEventListener('click', () => {
                        // show navbar
                        nav.classList.remove('hide')
                        nav.classList.toggle('show-sidebar')
                        // change icon
                        toggle.classList.toggle('bx-x')
                        toggle.classList.toggle('body-pd')

                        // // add padding to body
                        // bodypd.classList.toggle('body-pd')
                        // // add padding to header
                        // headerpd.classList.toggle('body-pd')
                    });
                } else {
                    toggle.addEventListener('mouseenter', () => {
                        console.log('mouse over');
                        if (!headerOpen) {
                            // show navbar
                            nav.classList.remove('hide')
                            nav.classList.toggle('show-sidebar')
                            $('#name_company').text(`{{env('APP_NAME')}}`);

                            // // change icon
                            // toggle.classList.toggle('bx-x')
                            // // add padding to body
                            // bodypd.classList.toggle('body-pd')
                            // // add padding to header
                            // headerpd.classList.toggle('body-pd')
                            headerOpen = true;
                        }

                    });

                    toggle.addEventListener('mouseleave', () => {
                        console.log('mouse out');

                        if (headerOpen) {
                            // show navbar
                            nav.classList.remove('show-sidebar')
                            nav.classList.toggle('hide')
                            $('#name_company').text('');
                            headerOpen = false;
                            collapseAllChild();
                        }

                    });
                }


            }
        }
        let toggleTrigger = 'nav-bar';

        if (screenWidth <= 768) {
            toggleTrigger = 'header-toggle';
            $('#header').show();

        }else{
            $('#header').hide();
            $('#name_company').text('');

        }

        showNavbar(toggleTrigger, 'nav-bar', 'body-pd', 'header')

        /*===== LINK ACTIVE =====*/
        // const linkColor = document.querySelectorAll('.nav_link')

        // function colorLink() {
        //     if (linkColor) {
        //         linkColor.forEach(l => l.classList.remove('active'))
        //         this.classList.add('active')
        //     }
        // }
        // linkColor.forEach(l => l.addEventListener('click', colorLink))

        // Your code to run since DOM is loaded and ready
    });
</script>


@yield('script')
@yield('script2')
@yield('script3')
@yield('script4')
@yield('scriptend')


@yield('style')
@yield('style2')
@yield('style3')
@yield('styleend')



</html>
