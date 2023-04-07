{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-start">
            @foreach ($items as $item)
                <div style="width:152px; border:solid 1px black; margin:5px !important; padding:0px;">
                    <img src="{{$item->url_qr_code}}" style="width:150px; height:150px;">
                    <div style="width:100%;" class="d-flex justify-content-center">
                        <h4 style="text-align:center; margin:0px;">{{$item->id}}</h4>
                    </div>
                </div>
            @endforeach

        </div>
    </div>



@endsection --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>

<body>
    <div id="app">
        <main style="padding-top:0px;">
            <div class="container">

                {{-- {{dd($product->warehouses())}} --}}
                @foreach ($product->warehouses as $warehouse)
                    <div class="row d-flex justify-content-start">
                        <div>
                            Kho hàng : {{$warehouse->name}} -- Số lượng : {{$warehouse->amount}}
                        </div>
                            @foreach (range(1, $warehouse->pivot->amount) as $step)
                                <div style="width:102px; border:solid 1px black; margin:5px !important; padding:0px;">
                                    <img src="{{ $product->url_qr_code }}" style="width:100px; height:100px;">
                                    <div style="width:100%;" class="d-flex justify-content-center">
                                        <h6 style="text-align:center; margin:0px; font-size:8px;">
                                            {{ $product->id }}-{{ isset($warehouse->id) ? $warehouse->id : '' }}</h6>
                                    </div>
                                </div>
                            @endforeach
                @endforeach

            </div>
        </main>
    </div>
</body>

<script>
    $(document).ready(() => {
        window.print();

    });
</script>

</html>
