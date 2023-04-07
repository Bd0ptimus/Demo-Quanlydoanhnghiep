@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">Các công cụ marketing</h6>
                </div>
                <div class ="row">
                    <div class="col-md-3 d-flex justify-content-center p-2" onclick="redirectTo(`{{route('admin.marketingChannel.discountProduct.index')}}`)">
                        <div class="d-flex justify-content-center marketing-card" style="width:100%; height:120px; background-color:#FAFAFA; cursor:pointer; transition: box-shadow 0.6s;">
                            <div class="d-flex justify-content-center vertical-container" style="width:30%; height:100%;">
                                <div class="vertical-element-middle-align d-flex justify-content-center" style="width:50px; height:50px; border-radius:50%; background-color:#F6412E;">
                                    <i class="fa-solid fa-ticket fa-2xl vertical-element-middle-align"></i>
                                </div>
                            </div>
                            <div class="d-block justify-content-center vertical-container" style="width:70%; height:100%;">
                                <div style="width:100%; height:40%; position:relative;" >
                                    <h6 style="font-size:15px; font-weight:600; margin:0px; position:absolute; bottom:0px;" >Giảm giá sản phẩm</h6>
                                </div>

                                <div style="width:100%; height:60%;" >
                                    <p style="font-size:12px; font-weight:500; margin:0px; color:#A599A5;" >Công cụ giúp tạo mã giảm giá cho từng sản phẩm. Công cụ này cho phép thêm mã giảm giá cho từng sản phẩm đơn lẻ.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center p-2">
                        <div class="d-flex justify-content-center  marketing-card" style="width:100%; height:120px; background-color:#FAFAFA; cursor:pointer; transition: box-shadow 0.6s;">
                            <div class="d-flex justify-content-center vertical-container" style="width:30%; height:100%;">
                                <div class="vertical-element-middle-align d-flex justify-content-center" style="width:50px; height:50px; border-radius:50%; background-color:#F6412E;">
                                    <i class="fa-solid fa-percent fa-2xl vertical-element-middle-align"></i>
                                </div>
                            </div>
                            <div class="d-block justify-content-center vertical-container" style="width:70%; height:100%;">
                                <div style="width:100%; height:40%; position:relative;" >
                                    <h6 style="font-size:15px; font-weight:600; margin:0px; position:absolute; bottom:0px;" >Chương trình giảm giá</h6>
                                </div>

                                <div style="width:100%; height:60%;" >
                                    <p style="font-size:12px; font-weight:500; margin:0px; color:#A599A5;" >Công cụ giúp tạo chương trình giảm giá. Công cụ này sẽ cho phép giảm giá nhiều sản phẩm trong một chương trình.</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 d-flex justify-content-center p-2">
                        <div class="d-flex justify-content-center  marketing-card" style="width:100%; height:120px; background-color:#FAFAFA; cursor:pointer; transition: box-shadow 0.6s;">
                            <div class="d-flex justify-content-center vertical-container" style="width:30%; height:100%;">
                                <div class="vertical-element-middle-align d-flex justify-content-center" style="width:50px; height:50px; border-radius:50%; background-color:#F6412E;">
                                    <i class="fa-solid fa-gifts fa-2xl vertical-element-middle-align"></i>
                                </div>
                            </div>
                            <div class="d-block justify-content-center vertical-container" style="width:70%; height:100%;">
                                <div style="width:100%; height:40%; position:relative;" >
                                    <h6 style="font-size:15px; font-weight:600; margin:0px; position:absolute; bottom:0px;" >Combo khuyến mãi</h6>
                                </div>

                                <div style="width:100%; height:60%;" >
                                    <p style="font-size:12px; font-weight:500; margin:0px; color:#A599A5;" >Công cụ giúp tạo combo được bán với giá ưu đãi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center p-2">
                        <div class="d-flex justify-content-center  marketing-card" style="height:120px; background-color:#FAFAFA; cursor:pointer; transition: box-shadow 0.6s;">
                            <div class="d-flex justify-content-center vertical-container" style="width:30%; height:100%;">
                                <div class="vertical-element-middle-align d-flex justify-content-center" style="width:50px; height:50px; border-radius:50%; background-color:#F6412E;">
                                    <i class="fa-solid fa-bolt fa-2xl vertical-element-middle-align"></i>
                                </div>
                            </div>
                            <div class="d-block justify-content-center vertical-container" style="width:70%; height:100%;">
                                <div style="width:100%; height:40%; position:relative;" >
                                    <h6 style="font-size:15px; font-weight:600; margin:0px; position:absolute; bottom:0px;" >Flash Sale</h6>
                                </div>

                                <div style="width:100%; height:60%;" >
                                    <p style="font-size:12px; font-weight:500; margin:0px; color:#A599A5;" >Công cụ giúp tạo khuyến mãi khủng trong các khung giờ nhất định</p>
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
<style>
    .marketing-card:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection
@section('script')
<script>
    function redirectTo(url){
        window.location.href = url;
    }
</script>
@endsection
