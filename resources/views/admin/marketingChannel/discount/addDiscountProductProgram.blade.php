@extends('layouts.app')

@section('content')
    @php
        use App\Models\Product;

    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center" style="padding:0px; width:100%; margin:0px;">
                <div class="row d-flex justify-content-center" style="margin : 5px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 5px auto; padding:0px;">
                        <div  style="width:100%; padding:0px;">
                            <div >
                                <div class="card my-2">
                                    <div class="card-header"><h6 class="webcard-title">TẠO CHƯƠNG TRÌNH GIẢM GIÁ</h6></div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('admin.marketingChannel.discountProduct.addDiscountProduct') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-form-label text-md-end">Tên chương
                                                    trình<span class="text-danger">(*)</span></label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                                        value="{{ old('name') }}" autocomplete="name" autofocus required>


                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                            </div>

                                            <div class="row mb-3">
                                                <label for="programCode" class="col-md-4 col-form-label text-md-end">Mã
                                                    chương trình
                                                    <span class="text-danger"></span></label>
                                                <div class="col-md-6">
                                                    <input id="programCode" type="text"
                                                        class="form-control @error('programCode') is-invalid @enderror"
                                                        name="programCode" value="{{ old('programCode') }}"
                                                        autocomplete="name" autofocus>

                                                    @error('programCode')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="availableDate"
                                                    class="col-md-4 col-form-label text-md-end">Khoảng thời gian áp
                                                    dụng<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-start" style="color:black!important;">
                                                        {{-- <input class="form-control dateTimeInput" type="text" required name="startDate" style="color:black;"/>  <input class="form-control dateTimeInput" type="text" required name="endDate" style="color:black;"/> --}}
                                                        <input class="form-control dateTimeInput" type="text" required name="daterange" style="color:black;"/>

                                                    </div>

                                                    @error('availableDate')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="discountType"
                                                    class="col-md-4 col-form-label text-md-end">Loại giảm giá<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <select id="discountType" name='discountType'
                                                        class="form-control @error('discountType') is-invalid @enderror" onchange="changeTypeDiscount()">
                                                        <option value="{{DISCOUNT_WITH_PERCENT}}">Giảm giá theo phần trăm giá niêm yết sản phẩm</option>
                                                        <option value="{{DISCOUNT_WITH_FIXED_PRICE}}" selected>Giảm giá cố định</option>

                                                    </select>
                                                    @error('discountType')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="discountRate"
                                                    class="col-md-4 col-form-label text-md-end" id="discountRateTitle">Giảm giá cố định (VND)<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input onchange="discountRateChange()" name="discountRate" type="number" id="discountRate" class="form-control" required/>

                                                    @error('discountRate')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="productApply"
                                                    class="col-md-4 col-form-label text-md-end" id="discountRateTitle">Sản phẩm áp dụng<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <select class="productApply form-control @error('productApply') is-invalid @enderror" name="productApply[]" multiple="multiple">
                                                        @foreach (Product::get() as $product)
                                                            <option value="{{$product->id}}">
                                                                    {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                      </select>
                                                    @error('productApply')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Tạo chương trình
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/mobiscroll.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('css/mobiscroll.jquery.min.css?v=') . time() }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
@endsection

@section('script2')
    <script>
        let discountType = `{{DISCOUNT_WITH_FIXED_PRICE}}`;
        function changeTypeDiscount(){
            if($('#discountType').val() == `{{DISCOUNT_WITH_PERCENT}}`){
                $('#discountRateTitle').text('Giảm giá theo số % ');
                discountType = `{{DISCOUNT_WITH_PERCENT}}`;
                if($('#discountRate').val()>100){
                    $('#discountRate').val(100);
                }else if($('#discountRate').val()<0){
                    $('#discountRate').val(1);

                }
            }else{
                $('#discountRateTitle').text('Giảm giá cố định (VND)');
                discountType = `{{DISCOUNT_WITH_FIXED_PRICE}}`;

            }
        }
        function discountRateChange(){
            if($('#discountType').val() == `{{DISCOUNT_WITH_PERCENT}}`){
                if($('#discountRate').val()>100){
                    $('#discountRate').val(100);
                }else if($('#discountRate').val()<0){
                    $('#discountRate').val(1);

                }
            }

        }
        $(function() {
            // $('.dateTimeInput').datetimepicker({
            //     useCurrent: true,
            //     format: "DD/MM/YYYY HH:mm:ss",

            // });

            $('.productApply').select2();

            // $('#multiple-shift').mobiscroll().select({
            //     inputElement: document.getElementById('productApply'),
            //     touchUi: false
            // });
            $('.dateTimeInput').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(720, 'hour'),
                opens: 'right',
                locale: {
                    format: 'DD/MM/YYYY HH:mm:ss',
                    separator: '  - ',
                    applyLabel: 'Áp dụng',
                    cancelLabel: 'Hủy bỏ',
                    fromLabel: 'Từ',
                    toLabel: 'Đến',
                    customRangeLabel: 'Tùy chỉnh',
                    daysOfWeek: [
                        'CN',
                        'T2',
                        'T3',
                        'T4',
                        'T5',
                        'T6',
                        'T7'
                    ],
                    monthNames: [
                        'Tháng 1',
                        'Tháng 2',
                        'Tháng 3',
                        'Tháng 4',
                        'Tháng 5',
                        'Tháng 6',
                        'Tháng 7',
                        'Tháng 8',
                        'Tháng 9',
                        'Tháng 10',
                        'Tháng 11',
                        'Tháng 12',
                    ],
                }
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
