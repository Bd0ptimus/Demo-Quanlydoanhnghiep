

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hóa đơn số : #{{$invoice->id }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        .text-muted {
            height: 35px;
        }

        .card-body {
            padding: 10px 0px !important;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>


    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/04e9a3dbb4.js" crossorigin="anonymous"></script>


</head>
<body >
    @php
        use Carbon\Carbon;
        Carbon::setLocale(env('APP_LOCAL'));
    @endphp
    <div id="app">
        <main style="padding-top:0px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="row product-section d-flex justify-content-center">
                        <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row d-flex align-items-baseline" style="width:100%; margin:0px;">
                                            <div class="col-xl-9">
                                                <p style="color: #7e8d9f;font-size: 20px;">{{ __('Invoice') }} >> <strong>ID:
                                                        #{{ $invoice->id }}</strong>
                                                </p>
                                            </div>
                                            <div class="col-xl-3 float-end">
                                                <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark" id="print-btn"><i
                                                        class="fas fa-print text-primary"></i> {{ __('Print') }}</a>
                                                {{-- <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i
                                                        class="far fa-file-pdf text-danger"></i> {{ __('Export to PDF') }}</a> --}}

                                            </div>
                                            <hr>
                                        </div>

                                        <div class="container">
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    {{-- <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i> --}}
                                                    <p class="pt-0">{{env('APP_NAME')}}</p>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="col-xl-8" style="padding:2px;">
                                                    <ul class="list-unstyled">
                                                            <li class="text-muted">{{ __('Buyer Name') }}:
                                                                <span style="color:#5d9fc5 ;">
                                                                    {{$invoice->buyer_name}}
                                                                </span>
                                                            </li>
                                                            <li class="text-muted">{{ __('Buyer Address') }}:
                                                                <span style="color:#5d9fc5 ;">
                                                                    {{$invoice->buyer_address}}
                                                                </span>
                                                            </li>
                                                            <li class="text-muted">
                                                                {{ __('Buyer Telephone Number') }}:<i class="fas fa-phone"
                                                                    style="margin:0px 10px;"></i>
                                                                <span style="color:#5d9fc5 ; width : auto;">
                                                                    {{$invoice->buyer_telephone}}
                                                                </span>
                                                            </li>

                                                        {{-- <li class="text-muted"><i class="fas fa-phone"></i> 123-456-789</li> --}}
                                                    </ul>
                                                </div>
                                                <div class="col-xl-4">
                                                    <p class="text-muted">{{ __('Invoice') }}</p>
                                                    <ul class="list-unstyled">
                                                        <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                            <span class="fw-bold">ID:</span>#{{ $invoice->id }}
                                                        </li>
                                                        <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                            <span class="fw-bold">{{ __('Creation Date') }}:
                                                            </span>{{ date('d-m-Y H:i:s', strtotime($invoice->created_at)) }}
                                                        </li>
                                                        {{-- <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                            <span class="me-1 fw-bold">Status:</span><span
                                                                class="badge bg-warning text-black fw-bold">
                                                                Unpaid</span></li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="table-responsive row " style="margin : 0px; width:100%;">
                                                <table class="table"
                                                    style="margin : 0px; width:100%; table-layout: fixed;">
                                                    <thead style="background-color:white ;" class="text-black" >
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">{{ __('Product Name') }}</th>
                                                            <th scope="col">{{ __('Price') }}&ensp;VND</th>
                                                            <th scope="col">{{ __('Amount') }}</th>
                                                            <th scope="col">{{ __('Sum') }}&ensp;VND</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="invoice-table">
                                                        @foreach($itemData as $key=>$item)
                                                            <tr>
                                                                <th scope="row">{{$key+1}}</th>
                                                                <td><a target="_blank" href="{{route('product.index',['productId' =>$item['productId'] ])}}">{{$item['name']}}</a></td>
                                                                <td>{{number_format($item['singlePrice'])}}</td>
                                                                <td>{{$item['number']}}</td>
                                                                <td>{{number_format($item['sumPrice'])}}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    {{-- <ul class="list-unstyled">
                                                        <li class="text-muted ms-3"><span
                                                                class="text-black me-4">{{__('Total amount to be paid')}}</span>$1110</li>
                                                    </ul> --}}
                                                    <p class="text-black float-start"><span class="text-black me-3">
                                                            {{ __('Total amount to be paid') }}</span><span
                                                            style="font-size: 25px;" id="totalToPay">{{number_format($sumToPay)}}&ensp;VND</span></p>
                                                </div>
                                            </div>
                                            <hr>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @include('layouts.confirmNotification')

        </main>
    </div>
</body>

<script>
    $(document).ready(()=>{
        $('#print-btn').on('click',()=>{
            window.print();
        });
    });
</script>
</html>





{{--@extends('layouts.app')

     @section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale(env('APP_LOCAL'));
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row d-flex align-items-baseline" style="width:100%; margin:0px;">
                                    <div class="col-xl-9">
                                        <p style="color: #7e8d9f;font-size: 20px;">{{ __('Invoice') }} >> <strong>ID:
                                                #{{ $invoice->id }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-xl-3 float-end">
                                        <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark" id="print-btn"><i
                                                class="fas fa-print text-primary"></i> {{ __('Print') }}</a>

                                    </div>
                                    <hr>
                                </div>

                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <p class="pt-0">I-Tech.co</p>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-xl-8" style="padding:2px;">
                                            <ul class="list-unstyled">
                                                    <li class="text-muted">{{ __('Buyer Name') }}:
                                                        <span style="color:#5d9fc5 ;">
                                                            {{$invoice->buyer_name}}
                                                        </span>
                                                    </li>
                                                    <li class="text-muted">{{ __('Buyer Address') }}:
                                                        <span style="color:#5d9fc5 ;">
                                                            {{$invoice->buyer_address}}
                                                        </span>
                                                    </li>
                                                    <li class="text-muted">
                                                        {{ __('Buyer Telephone Number') }}:<i class="fas fa-phone"
                                                            style="margin:0px 10px;"></i>
                                                        <span style="color:#5d9fc5 ; width : auto;">
                                                            {{$invoice->buyer_telephone}}
                                                        </span>
                                                    </li>

                                            </ul>
                                        </div>
                                        <div class="col-xl-4">
                                            <p class="text-muted">{{ __('Invoice') }}</p>
                                            <ul class="list-unstyled">
                                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                    <span class="fw-bold">ID:</span>#{{ $invoice->id }}
                                                </li>
                                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                    <span class="fw-bold">{{ __('Creation Date') }}:
                                                    </span>{{ date('d-m-Y H:i:s', strtotime($invoice->created_at)) }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="table-responsive row " style="margin : 0px; width:100%;">
                                        <table class="table table-striped table-borderless"
                                            style="margin : 0px; width:100%;">
                                            <thead style="background-color:#84B0CA ;" class="text-white">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('Product Name') }}</th>
                                                    <th scope="col">{{ __('Price') }}&ensp;VND</th>
                                                    <th scope="col">{{ __('Amount') }}</th>
                                                    <th scope="col">{{ __('Sum') }}&ensp;VND</th>

                                                </tr>
                                            </thead>
                                            <tbody id="invoice-table">
                                                @foreach($itemData as $key=>$item)
                                                    <tr>
                                                        <th scope="row">{{$key+1}}</th>
                                                        <td><a target="_blank" href="{{route('product.index',['productId' =>$item['productId'] ])}}">{{$item['name']}}</a></td>
                                                        <td>{{$item['singlePrice']}}</td>
                                                        <td>{{$item['number']}}</td>
                                                        <td>{{$item['sumPrice']}}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <p class="text-black float-start"><span class="text-black me-3">
                                                    {{ __('Total amount to be paid') }}</span><span
                                                    style="font-size: 25px;" id="totalToPay">{{$sumToPay}}&ensp;VND</span></p>
                                        </div>
                                    </div>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('layouts.confirmNotification')
@endsection

@section('style')
    <style>
        .text-muted {
            height: 35px;
        }

        .card-body {
            padding: 10px 0px !important;
        }
    </style>
@endsection

@section('script')
<script>
    $(document).ready(()=>{
        $('#print-btn').on('click',()=>{
            window.print();
        });
    });
</script>
@endsection --}}
