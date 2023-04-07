@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 " style="padding:0px;">

                <nav>
                    <div class="nav nav-tabs d-flex justify-content-start" id="nav-tab" role="tablist">
                        <button class="nav-link active productTabs" id="nav-warehouse-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-warehouse" type="button" role="tab" aria-controls="nav-warehouse"
                            aria-selected="true">Kho Hàng</button>
                        <button class="nav-link productTabs" id="nav-category-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-category" type="button" role="tab" aria-controls="nav-category"
                            aria-selected="false">Nhóm Sản Phẩm</button>
                        <button class="nav-link productTabs" id="nav-product-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-product" type="button" role="tab" aria-controls="nav-product"
                            aria-selected="false">Sản Phẩm</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="position: relative;">


                    <div class="tab-pane fade show active" id="nav-warehouse" role="tabpanel"
                        aria-labelledby="nav-warehouse-tab" tabindex="0">
                        <div class="row d-flex justify-content-center" style="width:100%; margin: 30px auto;">
                            <h4 style="text-align:center; font-weight:700;">KHO HÀNG</h4>
                            <div class="row" style="width : 200px;">
                                <a class="btn btn-primary" href="{{ route('admin.product.warehouse.addWarehouse') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <i class="fa-solid fa-plus"></i><span> Thêm kho hàng</span>
                                </a>
                            </div>
                            <div style="margin-top:20px; padding:0px; width:100vw; ">
                                <table id="warehouseTable"
                                    class="cell-border productTable display white-space: word-wrap: break-word;"
                                    style="color:black !important;  width:100%;">
                                    <thead style="background-color: #0D6EFD; color:white;">
                                        <tr>
                                            <th data-sortable="true" scope="col">TT</th>
                                            <th data-sortable="true" scope="col">Tên</th>
                                            <th data-sortable="true" scope="col">Địa chỉ</th>

                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($warehouses as $key => $warehouse)
                                            <tr>
                                                <td scope="col">{{ $key + 1 }}</td>
                                                <td scope="col">{{ $warehouse->name }}</td>
                                                <td scope="col">{{ $warehouse->address }}</td>

                                                <td>

                                                    <a class="btn interact-btn" style="background-color:red;"
                                                        onclick="deleteWarehouse(`{{ route('admin.product.warehouse.deleteWarehouse', ['warehouseId' => $warehouse->id]) }}`)">
                                                        Xóa</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab"
                        tabindex="0">
                        <div class="row d-flex justify-content-center " style="width:100%; margin: 30px auto;">
                            <h4 style="text-align:center; font-weight:700;">NHÓM SẢN PHẨM</h4>
                            <div class="row" style="width : 200px;">
                                <a class="btn btn-primary" href="{{ route('admin.product.category.addCategory') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <i class="fa-solid fa-plus"></i><span> Thêm nhóm sản phẩm</span>
                                </a>
                            </div>
                            <div style="margin-top:20px; padding:0px; width:100vw;">
                                <table id="categoryTable" class="productTable display white-space: word-wrap: break-word;"
                                    style="color:black;  width:100%;">
                                    <thead style="background-color: #0D6EFD; color:white;">
                                        <tr>
                                            <th data-sortable="true" scope="col">TT</th>
                                            <th data-sortable="true" scope="col">Tên nhóm</th>
                                            <th data-sortable="true" scope="col">Mô tả</th>

                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $category)
                                            @php
                                                $descriptionCategory = '';
                                                if (strlen(nl2br($category->description)) < 100) {
                                                    $descriptionCategory = nl2br($category->description);
                                                } else {
                                                    $desCateId = 'categoryDes-' . $category->id;
                                                    $descriptionCategory = substr(nl2br($category->description), 0, 100) . '...' . '<a onclick="seeMore(`' . nl2br($category->description) . '`,`' . $desCateId . '`,`Mô tả cho ' . $category->category_name . '`)" style="color:blue; cursor:pointer; font-size: 13px;">Xem thêm</a>';
                                                }
                                            @endphp
                                            <tr>
                                                <td scope="col">{{ $key + 1 }}</td>
                                                <td scope="col">{{ $category->category_name }}</td>
                                                <td scope="col">
                                                    <p id="categoryDes-{{ $category->id }}">{!! $descriptionCategory !!}</p>
                                                    {{-- <p id="categoryDes-{{$category->id}}">{!!nl2br($category->description)!!}</p> --}}

                                                </td>
                                                <td>

                                                    <a class="btn interact-btn" style="background-color:red;"
                                                        onclick="deleteCategory(`{{ route('admin.product.category.deleteCategory', ['categoryId' => $category->id]) }}`)">
                                                        Xóa</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab"
                        tabindex="0">
                        <div class="row d-flex justify-content-center" style="width:100%; margin: 30px auto;">
                            <h4 style="text-align:center; font-weight:700;">SẢN PHẨM</h4>
                            <div class="row" style="width : 200px;">
                                <a class="btn btn-primary" href="{{ route('admin.product.addProduct') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <i class="fa-solid fa-plus"></i><span> Thêm sản phẩm</span>
                                </a>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div class="row d-flex align-items-baseline" style="width:100%; margin:0px;">
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
                            </div>
                            <div style="margin-top:20px; padding:0px; width:100vw;">
                                <table id="productsTable" class="productTable display white-space: word-wrap: break-word;"
                                    style="color:black; width:100%;">
                                    <thead style="background-color: #0D6EFD; color:white;">
                                        <tr>
                                            <th data-sortable="true" scope="col">TT</th>
                                            <th data-sortable="true" scope="col">Tên SP</th>
                                            <th data-sortable="true" scope="col">Đơn giá (&#8363;)</th>
                                            <th data-sortable="true" scope="col">Mô tả</th>
                                            <th data-sortable="true" scope="col">Nhóm sản phẩm</th>

                                            <th data-sortable="true" scope="col">Ảnh</th>
                                            <th data-sortable="true" scope="col">Tồn kho</th>
                                            <th data-sortable="true" scope="col">Đã bán</th>


                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            @php
                                                $descriptionProduct = '';
                                                if (strlen(nl2br($product->description)) < 100) {
                                                    $descriptionProduct = nl2br($product->description);
                                                } else {
                                                    $desProdId = 'productDes-' . $product->id;
                                                    $descriptionProduct = substr(nl2br($product->description), 0, 100) . '...' . '<a onclick="seeMore(`' . nl2br($product->description) . '`,`' . $desProdId . '`,`Mô tả cho ' . $product->name . '`)" style="color:blue; cursor:pointer; font-size: 13px;">Xem thêm</a>';
                                                }
                                            @endphp
                                            <tr>
                                                <td scope="col">{{ $key + 1 }}</td>
                                                <td scope="col">{{ $product->name }}</td>
                                                <td scope="col">{{ number_format($product->price) }}</td>
                                                <td scope="col">
                                                    <p id="productDes-{{ $product->id }}">{!! $descriptionProduct !!}</p>
                                                </td>
                                                <td scope="col">
                                                    @foreach ($product->categories as $category)
                                                        <p style="margin:0px;">{{ $category->category_name }}</p>
                                                    @endforeach
                                                </td>
                                                <td scope="col">
                                                    @foreach ($product->productAttachments as $attachment)
                                                        <img src="{{ $attachment->url }}"
                                                            style="height : 60px; width:auto; margin: 10px;"
                                                            onclick="showFullImage('{{ $attachment->url }}')" />
                                                    @endforeach
                                                </td>
                                                @php
                                                    $productAmountExisted = isset($product->warehouseProducts) ? $product->warehouseProducts->sum('amount') : 0;
                                                    $productAmountSold = isset($product->productSold) ? $product->productSold->amount_sold : 0;
                                                @endphp
                                                <td scope="col">
                                                    {{ $productAmountExisted }} <a
                                                        onclick="watchDetailAmount({{ $product->id }})"
                                                        style="cursor:pointer; font-size:12px; color:blue;">Xem chi
                                                        tiết</a>
                                                </td>

                                                <td scope="col">
                                                    {{ $productAmountSold }}
                                                <td>

                                                    <a class="btn interact-btn" style="background-color:blue;"
                                                        href="{{ route('admin.product.updateProduct', ['productId' => $product->id]) }}">
                                                        Chỉnh sửa</a>

                                                    <a class="btn interact-btn" style="background-color:gray;"
                                                        href="{{ route('admin.product.printQrCode', ['productId' => $product->id]) }}"
                                                        target="_blank">
                                                        In mã QR cho các sản phẩm</a>

                                                    <a class="btn interact-btn" style="background-color:green;"
                                                        onclick="increaseItem({{ $product->id }}, `{{ $product->name }}`, `{{ $productAmountExisted }}`)">
                                                        Thêm số lượng mặt hàng</a>
                                                    <a class="btn interact-btn" style="background-color:orange;"
                                                        onclick="resetItem({{ $product->id }}, `{{ $product->name }}`, `{{ $productAmountExisted }}`)">
                                                        Đặt lại số lượng mặt hàng</a>
                                                    <a class="btn interact-btn" style="background-color:red;"
                                                        href="{{ route('admin.product.deleteProduct', ['productId' => $product->id]) }}">
                                                        Xóa</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>



            </div>
        </div>
    </div>
    </div>
    @include('admin.product.increaseNumItem')
    @include('admin.product.resetNumItem')
    @include('admin.product.watchProductAmountDetail')
    @include('layouts.showFullImage')
    @include('layouts.seeMoreDescription')
@endsection
@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <style>
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
    <script type="text/javascript">
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

        function checkUrl(url) {
            let domain = (new URL(url));
            console.log('domain : ', domain.hostname);
            console.log('pathname : ', domain.pathname);
            let urlPost = `{{ route('admin.invoice.addItem') }}`;
            if (domain.hostname == `{{ env('APP_DOMAIN') }}` && domain.pathname.includes('product')) {
                let pathList = domain.pathname.split('/');
                let productId = pathList[pathList.length - 1];
                takeAmountDetail(productId);
            } else {
                $('#toast-fail-text').text('QR không hợp lệ');
                $('#notification-success').toast('hide');
                $('#notification-fail').toast('show');
            }


        }


        function takeAmountDetail(productId) {
            let urlPost = `{{ route('admin.product.warehouse.amountDetail') }}`;

            $.ajax({
                method: 'post',
                url: urlPost,
                data: {
                    productId: productId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('data response in promotion choose : ', JSON.stringify(data));
                    if (data.error == 0) {
                        console.log(data);
                        $('#amountDetailTable').empty();
                        $('#amountDetailTable').append(data.data.tableHtml);
                        $('#amountDetailProductName').val(data.data.name);
                        reloadTable();
                        $('#watchProductAmount-modal').modal('show');
                        // $('#invoice-table').empty();
                        // $('#invoice-table').append(data.data.itemHtml);
                        // $('#totalToPay').text(data.data.sum);
                    }
                }

            });
        }

        function watchDetailAmount(id) {
            takeAmountDetail(id);
        }

        function seeLess(fullContent, id, lessContent) {
            let contentToAdd = lessContent +
                `...<a onclick="seeMore('${fullContent}','${id}','${lessContent}')" style="color:blue; cursor:pointer; font-size: 13px;">xem thêm</a>`;
            $(`#${id}`).empty();

            $(`#${id}`).append(contentToAdd);
        }

        function seeMore(fullContent, id, titleContent) {
            // console.log('content : ', fullContent);
            // let contentToAdd = fullContent + `   <a onclick="seeLess('${fullContent}','${id}','${lessContent}')" style="color:blue; cursor:pointer; font-size: 13px;">rút gọn</a>`;
            // $(`#${id}`).empty();
            // $(`#${id}`).append(contentToAdd);
            $('#seeMoreDescriptionContent').empty();
            $('#seeMoreDescriptionContent').append(fullContent);
            $('#seeMoreDescriptionLabel').text(titleContent);

            $('#seeMoreDescription').modal('show');
        }

        function deleteCategory(url) {

            if (confirm(
                    "Nếu xóa nhóm sản phẩm này, các sản phẩm thuộc nhóm này cũng sẽ bị xóa. Bạn có chắc chắn muốn xóa?")) {
                window.location.href = url;
            }
        }

        function deleteWarehouse(url) {
            if (confirm(
                    "Nếu xóa kho hàng này, các sản phẩm thuộc kho hàng này cũng sẽ bị xóa. Bạn có chắc chắn muốn xóa?")) {
                window.location.href = url;
            }
        }

        function resetWarehouseAmountInput() {
            $('.warehouseInput').val('0');
        }

        // function reloadTable(id) {
        //     $(`#${id}`).reset();


        // }
        $(document).ready(function() {
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
            let productTable = $('.productTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(3)'
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
                },
                responsive: true
            });

            let tabIndex = getCookie('tab');

            console.log('tab cookie : ', tabIndex);
            if (tabIndex == `{{ WAREHOUSE_TAB }}`) {
                resetTab();
                $('#nav-warehouse-tab').addClass('active');
                $('#nav-warehouse').addClass('active');
                $('#nav-warehouse').addClass('show');

            } else if (tabIndex == `{{ CATEGORY_TAB }}`) {
                resetTab();
                $('#nav-category-tab').addClass('active');
                $('#nav-category').addClass('active');
                $('#nav-category').addClass('show');
            } else if (tabIndex == `{{ PRODUCT_TAB }}`) {
                resetTab();
                $('#nav-product-tab').addClass('active');
                $('#nav-product').addClass('active');
                $('#nav-product').addClass('show');
            }

            function resetTab() {
                $('.productTabs').removeClass('active');
                $('.tab-pane').removeClass('active');
                $('.tab-pane').removeClass('show');

            }

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


            $('#nav-warehouse-tab').on('click', function() {
                console.log('tab changed');
                setCookie('tab', `{{ WAREHOUSE_TAB }}`, 30);
            });

            $('#nav-category-tab').on('click', function() {
                console.log('tab changed');
                setCookie('tab', `{{ CATEGORY_TAB }}`, 30);

            });

            $('#nav-product-tab').on('click', function() {
                console.log('tab changed');
                setCookie('tab', `{{ PRODUCT_TAB }}`, 30);

            });

            function setCookie(cname, cvalue, exdays) {
                const d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                let expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

        });
    </script>
@endsection
