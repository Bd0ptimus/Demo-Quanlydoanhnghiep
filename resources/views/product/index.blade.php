@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-size:20; font-weight:600;">{{ $product->name }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <h5>
                                {{ __('Amount in stock') }} : <span style="font-weight:600;">{{ $amountItemInStock }}</span>
                            </h5>

                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div style="padding:0px;" class="d-flex justify-content-center">
                                    <div class="swiper mySwiper">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->productAttachments as $key => $attachment)
                                                <div class="swiper-slide d-flex justify-content-center">
                                                    <img class="newFeed-image2" src={{ $attachment->url }}>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-pagination"></div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <h6>
                                        {{ __('Price') }} : <span style="font-weight:600;">{{ number_format($product->price) }} VND</span>
                                    </h6>

                                </div>
                                <div class="row">
                                    <h6>
                                        {{ __('Description') }} :
                                    </h6>
                                    <div>
                                        {!!nl2br($product->description)??'...'!!}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
@endsection
@section('script')
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
@endsection
@section('script2')
    <script type="text/javascript">
        $(document).ready(function() {
            let swiper = new Swiper(".mySwiper", {
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        });
    </script>
@endsection
