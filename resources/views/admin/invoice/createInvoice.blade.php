@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale(env('APP_LOCAL'));
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 0px auto ;padding:0px;">
                    <div class="card" style="padding:0px; margin:0px; width:100%;">

                        <div class="card-body">
                            <div class="container" style="padding:5px; margin:0px; width:100%;">
                                <div class="row d-flex align-items-baseline" style="width:100%; margin:0px;">
                                    <div class="col-xl-9">
                                        <p style="color: #7e8d9f;font-size: 20px;">{{ __('Create Invoice') }}
                                        </p>
                                    </div>
                                    <div id="scanner"></div>
                                    <div class="col-xl-3 float-end">

                                        <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"
                                            id="scanner-form">
                                            <i class="fa-solid fa-qrcode"></i> {{ __('Start Scan') }}</a>
                                        <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"
                                            id="qr-scanner-closer" style="display:none;">
                                            <i class="fa-solid fa-ban text-danger"></i> {{ __('End Scan') }}</a>
                                    </div>
                                    <hr>
                                </div>

                                <div class="container" style="padding:0px; margin:0px; width:100%;">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <p class="pt-0">{{ env('APP_NAME') }}</p>
                                        </div>

                                    </div>


                                    <div class="row align-items-baseline" style="padding:0px; margin:0px; width:100%;">
                                        <div class="col-xl-8" style="padding:2px;">
                                            <ul class="list-unstyled">
                                                <form id="export-btn" method="POST" target="_blank"> @csrf
                                                    {{-- action="{{route('admin.invoice.exportInvoice',['invoiceId'=>$newInvoice->id])}}" --}}
                                                    <li class="text-muted">{{ __('Buyer Name') }}:
                                                        <span style="color:#5d9fc5 ;">
                                                            <input name="buyerName" type="text">
                                                        </span>
                                                    </li>
                                                    <li class="text-muted">{{ __('Buyer Address') }}:
                                                        <span style="color:#5d9fc5 ;">
                                                            <input name="buyerAddress" type="text">
                                                        </span>
                                                    </li>
                                                    <li class="text-muted">
                                                        {{ __('Buyer Telephone Number') }}:
                                                        <span style="color:#5d9fc5 ;">
                                                            <input name="buyerPhone" type="number">
                                                        </span>
                                                    </li>
                                                </form>
                                            </ul>
                                        </div>
                                        {{-- <div class="col-xl-4">
                                            <p class="text-muted">{{ __('Invoice') }}</p>
                                            <ul class="list-unstyled">
                                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                    <span class="fw-bold">ID:</span>#{{ $newInvoice->id }}
                                                </li>
                                                <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i>
                                                    <span class="fw-bold">{{ __('Creation Date') }}:
                                                    </span>{{ date('d-m-Y H:i:s', strtotime($newInvoice->created_at)) }}
                                                </li>

                                            </ul>
                                        </div> --}}
                                    </div>
                                    <div class="row" style="width:100%; margin:20px 0px; padding:0px;">
                                        <div class="row">
                                            <div class="row mb-3 d-flex justify-content-start">
                                                <label for="shift" class="col-md-2 col-form-label text-md-end"
                                                    style="font-weight : 700; font-size:30;">Chọn kho hàng
                                                </label>

                                                <div class="col-md-2">
                                                    @include('layouts.selectSingleTemplate')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="margin-top:20px; padding:0px; width:100%;">
                                            <table id="productTable" class="display white-space: word-wrap: break-word;">
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="true" scope="col">STT</th>

                                                        <th scope="col">Thao tác</th>

                                                        <th data-sortable="true" scope="col"
                                                            style="max-width:200px; white-space:normal;">Tên sản phẩm</th>
                                                        <th data-sortable="true" scope="col"
                                                            style="max-width:200px; white-space:normal;">Id sản phẩm</th>

                                                        <th data-sortable="true" scope="col">Giá bán (&#8363;)</th>
                                                        <th data-sortable="true" scope="col">Mô tả</th>
                                                        <th data-sortable="true" scope="col">Ảnh</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $key => $product)
                                                        <tr>
                                                            <td scope="col">{{ $key + 1 }}</td>
                                                            <td>
                                                                {{-- <a class="btn interact-btn" style="background-color:blue;"
                                                                    onclick="addProductToInvoice({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}')">
                                                                        Chọn</a>
                                                                <br> --}}

                                                                <input type="number" class="form-control"
                                                                    style="width:80px;"
                                                                    id="numberProduct-{{ $product->id }}"
                                                                    onchange="onChangeProductInvoice({{ $product->id }}, `{{ $product->name }}`, `{{ $product->price }}`)" />
                                                            </td>
                                                            <td scope="col" id="productName-{{ $product->id }}">
                                                                {{ $product->name }}</td>
                                                            <td scope="col" id="productId-{{ $product->id }}">
                                                                {{ $product->id }}</td>

                                                            <td scope="col" id="productPrice-{{ $product->id }}">
                                                                {{ number_format($product->price) }}</td>
                                                            <td scope="col">
                                                                <p>{!! nl2br($product->description) !!}</p>
                                                            </td>
                                                            <td scope="col">
                                                                @foreach ($product->productAttachments as $attachment)
                                                                    <img src="{{ $attachment->url }}"
                                                                        style="height : 60px; width:auto; margin: 10px;"
                                                                        onclick="showFullImage('{{ $attachment->url }}')" />
                                                                @endforeach
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="row" style="background-color : #F8F9FA;">
                                        <div class="row d-flex justify-content-start" style="margin:30px;">
                                            <p style="width:auto; margin:0px;">Thêm sản phẩm : </p>
                                            <input id="addIdItem" class="form-control" type="number"
                                                style="width: 100px;" placeholder="ID" />
                                            <input id="addAmountItem" class="form-control" type="number"
                                                style="width: 100px;" placeholder="Số lượng" />

                                            <i id="btnManualAddItem" class="fa-solid fa-square-plus fa-2xl"
                                                style="width:auto; padding-top:20px;"></i>
                                        </div>
                                    </div>

                                    <div class="table-responsive row " style="margin : 0px; width:100%;">
                                        <table class="table table-striped table-borderless"
                                            style="margin : 0px; width:100%;">
                                            <thead style="background-color:#84B0CA !important;" class="text-white">
                                                <tr>
                                                    <th scope="col">Chọn số lượng</th>

                                                    <th scope="col">{{ __('Product Name') }}</th>

                                                    <th scope="col">{{ __('Price') }}&ensp;(VND)</th>
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Thành tiền&ensp;(VND) </th>

                                                    <th scope="col">Khuyến mãi</th>
                                                    <th scope="col">{{ __('Action') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody id="invoice-table">
                                                {{-- <tr>
                                                    <th scope="row">1</th>
                                                    <td>Pro Package</td>
                                                    <td>1000000</td>
                                                    <td><i class="fa-solid fa-trash fa-xl text-danger"
                                                            style="height:30px;"></i></td>
                                                </tr> --}}
                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <p class="text-black float-start"><span class="text-black me-3">
                                                    {{ __('Total amount to be paid') }}</span><span
                                                    style="font-size: 25px;" id="totalToPay"></span></p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary text-capitalize"
                                                id="export-invoice" style="margin:2px;" onclick="exportInvoice()"
                                                style="background-color:#60bdf3 ;">{{ __('Export Invoice') }}</button>

                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary text-capitalize"
                                                onclick="window.location.reload()"
                                                style="background-color:red ; margin:2px;">{{ __('Cancel Invoice') }}</button>
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
    @include('layouts.confirmNotification')
    @include('layouts.showFullImage')
@endsection

@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <style>
        .text-muted {
            height: 35px;
        }

        .card-body {
            padding: 10px 0px !important;
        }

        .promotion-card {
            cursor: pointer;
            width: 200px;
            height: 50px;
            padding: 5px;
            margin: 5px;
            position: relative;
        }

        .promotion-card-unactive {
            background-color: #EC1D23;
            color: white;

        }

        .promotion-card-active {
            background-color: white;
            color: #EC1D23;
            border: solid 2px #EC1D23;
        }

        .promotion-container {
            overflow-y: scroll;
            padding: 5px;
        }

        .promotion-card-tittle {
            margin: 0px;
            font-size: 15px;
            font-weight: 600;
        }

        .promotion-card-text {
            margin: 0px;
            font-size: 12px;
            font-weight: 500;
        }

        #scanner {
            padding: 0px;
        }

        video {
            width: 100% !important;
        }
    </style>
@endsection


@section('script2')
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.3/dist/bootstrap-table-locale-all.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.7/html5-qrcode.min.js"
        integrity="sha512-dH3HFLqbLJ4o/3CFGVkn1lrppE300cfrUiD2vzggDAtJKiCClLKjJEa7wBcx7Czu04Xzgf3jMRvSwjVTYtzxEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var invoiceProduct = {};
        var totalPay = 0;
        const qrCodeScanner = new Html5Qrcode('scanner');
        const QRscanning = async () => {
            await Html5Qrcode.getCameras().then(async (devices) => {
                const config = {

                    fps: 15, // Set the capture frame rate to 15 FPS.
                    qrbox: 200, // Set the QR code scanning box size to 300 pixels.
                    aspectRatio: 1.5 // Set the aspect ratio of the QR code scanning box to 1.5.
                };

                const onSuccess = async (decodedText, decodedResult) => {
                    // prefix: 'https://coolmate.me'
                    console.log('scan success : ', decodedText);
                    if (decodedText.startsWith('')) {
                        qrCodeScanner.stop().then((ignore) => {
                            console.log(decodedResult);
                            $('#qr-scanner-closer').hide();
                            $('#scanner-form').show();
                            checkUrl(decodedText);
                            // window.location.href = decodedText;

                        }).catch((err) => {
                            // Stop failed, handle it.
                            console.log(err);
                        });
                        // console.log(decodedResult);
                        // checkUrl(decodedText);
                    }

                }
                const onError = (err) => {
                    console.warn(err);
                }
                if (devices.length > 1) {
                    await qrCodeScanner.start({
                        facingMode: "environment"
                    }, config, onSuccess, onError);
                } else
                    await qrCodeScanner.start(devices[0].id, config, onSuccess, onError);
            }).catch(err => {
                console.warn(err)
            });

        }

        function onChangeProductInvoice(productId, productName, productPrice) {
            let amount = $(`#numberProduct-${productId}`).val();
            if (amount < 1) {
                removeFromInvoice(productId);
                $(`#numberProduct-${productId}`).val('0');

            } else {
                addProductToInvoiceApi(productId, amount);
                $(`#amountChoice-${productId}`).val(amount);
            }
        }

        function checkUrl(url) {
            let domain = (new URL(url));
            console.log('domain : ', domain.hostname);
            console.log('pathname : ', domain.pathname);
            let urlPost = `{{ route('admin.invoice.addItem') }}`;
            if (domain.hostname == `{{ env('APP_DOMAIN') }}` && domain.pathname.includes('product')) {
                let pathList = domain.pathname.split('/');
                let productId = pathList[pathList.length - 1];
                let number = prompt("Hãy chọn số lượng", "");
                if (number == null || number == "") {
                    $('#toast-fail-text').text('Bạn phải nhập số lượng');
                    $('#notification-success').toast('hide');
                    $('#notification-fail').toast('show');
                } else {
                    addProductToInvoiceApi(productId, number);
                }
            } else {
                $('#toast-fail-text').text('QR không hợp lệ');
                $('#notification-success').toast('hide');
                $('#notification-fail').toast('show');
            }


        }

        function removeFromInvoice(id) {
            $(`#product-${id}`).remove();
            if (Object.hasOwn(invoiceProduct, id.toString())) {
                delete invoiceProduct[id.toString()];
            }
            $(`#numberProduct-${id}`).val('0');

            calculateTotalPay();
        }

        function resetAllProductPromotion(itemId) {
            $(`.promotionClass-${itemId}`).removeClass('promotion-card-active');
            $(`.promotionClass-${itemId}`).addClass('promotion-card-unactive');
            $(`.promotionClass-${itemId} i`).css('display', 'none');

        }

        function promotionChoose(productId, programId) {
            console.log('promotion choose');

            let urlPost = `{{ route('admin.marketingChannel.applyPromotionForItem') }}`;

            $.ajax({
                method: 'post',
                url: urlPost,
                data: {
                    productId: productId,
                    programId: programId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('data response in promotion choose : ', JSON.stringify(data));
                    if (data.error == 0) {
                        if (data.data.applyCompleted == 0) {
                            $('#toast-fail-text').text('Không thể sử dụng chương trình này');
                            $('#notification-success').toast('hide');
                            $('#notification-fail').toast('show');
                        } else {
                            applyPromotion(data.data.id, data.data.priceAfterPromotion, data.data.promotionId);
                            calculateTotalPay();
                        }
                        // $('#invoice-table').empty();
                        // $('#invoice-table').append(data.data.itemHtml);
                        // $('#totalToPay').text(data.data.sum);
                    }
                }

            });
        }

        function applyPromotion(id, priceAfterPromotion, promotionId) {
            $(`.promotionClass-${id}`).removeClass('promotion-card-active');
            $(`.promotionClass-${id}`).addClass('promotion-card-unactive');
            $(`.promotionClass-${id} i`).css('display', 'none');
            $(`#price-${id}`).empty();
            $(`#price-${id}`).append("<p style='font-size:16px; margin:0px;'>" + invoiceProduct[id]['price'].toLocaleString(
                "en-US") + "</p>");
            $(`#totalPrice-${id}`).empty();
            $(`#totalPrice-${id}`).append("<p style='font-size:16px; margin:0px;'>" + (invoiceProduct[id]['price'] *
                invoiceProduct[id]['amount']).toLocaleString("en-US") + "</p>");

            if (invoiceProduct[id]['promotionId'] == promotionId) {
                confirmProduct(id, invoiceProduct[id]['name'], invoiceProduct[id]['price'], invoiceProduct[id]['price'],
                    invoiceProduct[id]['amount'], null);
                // invoiceProduct[id]['priceAferPromotion']=  invoiceProduct[id]['price'];
                // invoiceProduct[id]['promotionId']= null;

            } else {
                confirmProduct(id, invoiceProduct[id]['name'], invoiceProduct[id]['price'], priceAfterPromotion,
                    invoiceProduct[id]['amount'], promotionId);

                // invoiceProduct[id]['priceAferPromotion']= priceAfterPromotion;
                // invoiceProduct[id]['promotionId']= promotionId;
                $(`#promotionProgram-${id}-${promotionId}`).addClass('promotion-card-active');
                $(`#promotionProgram-${id}-${promotionId} i`).css('display', 'block');
                $(`#price-${id}`).empty();
                $(`#price-${id}`).append("<p style='font-size:12px; margin:0px; text-decoration-line: line-through;'>" +
                    invoiceProduct[id]['price'].toLocaleString("en-US") +
                    "</p> <p style='font-size:16px; margin:0px;'>" + invoiceProduct[id]['priceAfterPromotion']
                    .toLocaleString("en-US") + "</p>");
                $(`#totalPrice-${id}`).empty();
                $(`#totalPrice-${id}`).append(
                    "<p style='font-size:12px; margin:0px; text-decoration-line: line-through;'>" + (invoiceProduct[id][
                        'price'
                    ] * invoiceProduct[id]['amount']).toLocaleString("en-US") +
                    "</p> <p style='font-size:16px; margin:0px;'>" + (invoiceProduct[id]['priceAfterPromotion'] *
                        invoiceProduct[id]['amount']).toLocaleString("en-US") + "</p>");

            }
        }

        function confirmProduct(id, name, singlePrice, priceAfterPromotion, amount, promotion) {
            if (!Object.hasOwn(invoiceProduct, id.toString())) {
                invoiceProduct[id] = {};
                invoiceProduct[id]['productId'] = id;
                invoiceProduct[id]['productName'] = name;
                invoiceProduct[id]['price'] = singlePrice;
            }
            invoiceProduct[id]['amount'] = amount;
            invoiceProduct[id]['promotionId'] = promotion;
            invoiceProduct[id]['priceAfterPromotion'] = priceAfterPromotion;
            console.log("invoiceProduct[id]['priceAfterPromotion'] : " + id + '-' + invoiceProduct[id][
                'priceAfterPromotion']);
            invoiceProduct[id]['totalPrice'] = amount * priceAfterPromotion;
        }

        function calculateTotalPay() {
            let totalPriceSum = 0;
            for (const key in invoiceProduct) {
                if (invoiceProduct.hasOwnProperty(key)) {
                    console.log(`total ${key} : `, invoiceProduct[key].totalPrice);
                    totalPriceSum += invoiceProduct[key].totalPrice;
                }
            }
            totalPay = totalPriceSum;
            $('#totalToPay').text(totalPriceSum.toLocaleString("en-US") + ' VND');
        }


        function exportInvoice() {
            if ($('#invoice-table').is(':empty')) {
                $('#toast-fail-text').text('Không thể xuất hóa đơn trống');
                $('#notification-success').toast('hide');
                $('#notification-fail').toast('show');
            } else {
                if (Object.keys(invoiceProduct).length !== 0) {
                    let urlPost = `{{ route('admin.invoice.exportInvoice') }}`;
                    $.ajax({
                        method: 'post',
                        url: urlPost,
                        data: {
                            invoiceData: invoiceProduct,
                            totalPay: totalPay,
                            warehouseId: {{ $warehouseChoice }},
                            buyerName: $('#buyerName').val() ?? null,
                            buyerAddress: $('#buyerAddress').val() ?? null,
                            buyerPhone: $('#buyerPhone').val() ?? null,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            console.log('data response : ', JSON.stringify(data));
                            if (data.error == 0) {
                                if (data.data.complete == 1) {
                                    let showInvoiceUrl = `{{ route('admin.invoice.showInvoice', '') }}` +
                                        "/" +
                                        data.data.newCheckoutId;
                                    window.open(showInvoiceUrl, '_blank');
                                    window.location.reload();


                                }
                            }
                            $('#manualAddItem').val('');
                        }

                    });
                }

            }
        }

        async function addProductToInvoiceApi(productId, amountId) {
            let urlPost = `{{ route('admin.invoice.addItem') }}`;

            $.ajax({
                method: 'post',
                url: urlPost,
                data: {
                    productId: productId,
                    amountId: amountId,
                    warehouseId: {{ $warehouseChoice }},

                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('data response add product : ', JSON.stringify(data));
                    if (data.error == 0) {
                        if (!data.data.productIsValid) { //error
                            $('#toast-fail-text').text(
                                'Không thể xác nhận sản phẩm này. Sản phẩm này có thể không tồn tại hoặc không có trong kho hàng hiện tại của bạn'
                                );
                            $('#notification-success').toast('hide');
                            $('#notification-fail').toast('show');


                        } else {
                            // $(`#invoice-table`).empty();
                            // data.data.items.forEach((e) => {
                            //     $(`#invoice-table`).append(e);
                            // });

                            if (Object.hasOwn(invoiceProduct, data.data.id
                                    .toString())) {
                                $(`#product-${data.data.id}`).remove();
                            }
                            $(`#invoice-table`).append(data.data.itemHtml);
                            confirmProduct(data.data.id, data.data.name, data.data
                                .singlePrice, data.data.singlePrice,
                                data.data.amount, null);

                            if (data.data.promotionId != null) {
                                console.log('IN promotion found');
                                // promotionChoose(data.data.id,data.data.promotionId );
                                applyPromotion(data.data.id, data.data.priceAfterPromotion, data.data
                                    .promotionId);
                            }
                            calculateTotalPay();

                            $('#toast-success-text').text(
                                'Sản phẩm đã thêm vào hóa đơn thành công');
                            $('#notification-fail').toast('hide');
                            $('#notification-success').toast('show');

                        }

                    }
                    $('#addIdItem').val('');
                    $('#addAmountItem').val('');

                }

            });
        }

        async function amountChoiceHandler(id) {
            let amountInput = $(`#amountChoice-${id}`).val();
            if (amountInput < 0) {
                $('#toast-success-fail').text(
                    'Số lượng không được chấp nhận');
                $('#notification-fail').toast('show');
                $('#notification-success').toast('hide');
                return;
            } else if (amountInput == 0) {
                removeFromInvoice(id);
            } else {
                await addProductToInvoiceApi(id, amountInput);
                $('#numberProduct-45').val(amountInput);
            }

        }


        $(document).ready(() => {
            console.log('abc start');
            $('#productTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(3)'
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
                },
                responsive: true
            });

            const scannerToggler = document.getElementById('scanner-form');
            scannerToggler.addEventListener('click', async () => {
                try {
                    $('#scanner-form').hide();
                    $('#qr-scanner-closer').show();

                    await QRscanning();
                } catch (e) {
                    console.log(e);
                }
            });
            const closer = document.getElementById('qr-scanner-closer');
            closer.addEventListener('click', async () => {
                $('#scanner-form').show();
                $('#qr-scanner-closer').hide();
                await qrCodeScanner.stop();

            })


            $('#btnManualAddItem').on('click', () => {

                if ($('#addIdItem').val() > 0 && $('#addAmountItem').val() > 0) {
                    addProductToInvoiceApi($('#addIdItem').val(), $('#addAmountItem').val());
                } else {
                    $('#toast-fail-text').text('Hãy nhập đầy đủ ID và số lượng');
                    $('#notification-success').toast('hide');
                    $('#notification-fail').toast('show');
                }
            });


            function updateParameter(urlCurrent, key, value) {
                let url = new URL(urlCurrent);
                let search_params = url.searchParams;

                // new value of "key" is set to "value"
                search_params.set(key, value);
                // search_params.set('page', 1);

                // change the search property of the main url
                url.search = search_params.toString();

                return url.toString();
            }

            $('#select2FormSingle').on('change', function() {
                window.location.href = updateParameter(window.location.href, 'warehouse', $(
                        '#select2FormSingle')
                    .val());
            });
        });
        const readFileQR = async (e) => {
            const html5QrCode = new Html5Qrcode( /* element id */ "reader");
            const imageFile = e.target.files[0];
            // Scan QR Code
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    // success, use decodedText
                    window.location.href = decodedText;
                })
                .catch(err => {
                    // failure, handle it.
                    console.log(`Error scanning file. Reason: ${err}`)
                });
        }
    </script>
@endsection
