@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="resetNum-modal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">

            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center;  padding:0px 50px;">Đặt lại lượng sản
                    phẩm</h4>
                <span id="resetNum-modal-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                <form id="resetItemForm" method="POST" action=""> @csrf
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Tên sản phẩm</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="100" style="border-colorsetupBorderColor" id="productNameReset"
                                name='productName' type="text" class="form-control h-100" value="" disabled />
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Số lượng hiện có</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="100" style="border-colorsetupBorderColor" id="productPriceReset"
                                name='productPrice' type="number" class="form-control h-100" value="" disabled />
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Đặt lại số lượng trong các kho</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <table class="productTable display white-space: word-wrap: break-word;" style="margin:0px; width:100%; padding:0px;">
                                <thead>
                                    <tr>
                                        <td data-sortable="true" scope="col">Kho hàng</td>
                                        <td data-sortable="true" scope="col">Số lượng ở kho hàng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouses as $key => $warehouse)
                                        <tr>
                                            <td scope="col">{{ $warehouse->name }}</td>
                                            <td scope="col"><input class="warehouseInput form-control" name="warehouse{{$warehouse->id}}" value="0"/></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>


                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button id="resetItem" type="submit" class="btn modal-btn btn-primary">Xác
                            nhận</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
    @section('style3')
        <style>

            .number-field .btn{
                background: #000000;
                color:#ffffff;
            }
            .modal-active {
                /* border-bottom: solid 3px #1d8daf; */
                color: white;
                background-color: #1d8daf;
                border-top-right-radius: 8px 8px;
                border-top-left-radius: 8px 8px;
            }

            .modalTitle {
                float: left;
                margin: 0px;
                padding: 10px 10px 0px;
            }

            .modalTitle:hover {
                transition: 0.4s;
                cursor: pointer;
                color: white;
                /* border-bottom: solid 3px #1d8daf; */
                background-color: #1d8daf;
                border-top-right-radius: 8px 8px;
                border-top-left-radius: 8px 8px;

            }

            .select2-dropdown {
                z-index: 2000;
            }


            @media screen and (min-width : 1020px) and (max-width: 5000px) {
                .modal-header {
                    padding: 10px 20px 0px;
                }
            }


            @media screen and (min-width : 820px) and (max-width: 1020px) {
                .modal-header {
                    padding: 10px 20px 0px;
                }
            }


            @media screen and (min-width : 450px) and (max-width: 820px) {
                .modal-header {
                    padding: 10px 0px 10px 5px;
                }
            }


            @media screen and (max-width: 450px) {
                .modal-header {
                    padding: 10px 0px 10px 5px;
                }
            }
        </style>
    @endsection
</div>
@section('script4')
    <script type="text/javascript">
         function resetItem(productId, productName, productPrice) {
            let updateFormAction = `{{ route('admin.product.resetProductItem', '') }}` + "/" + productId;
            resetItemResetForms();
            $('#resetItemForm').attr('action', updateFormAction);
            $('#productNameReset').val(productName);
            $('#productPriceReset').val(productPrice);


            $('#resetNum-modal').modal('show');

        }


        function resetItemResetForms() {
            $('#productName').val("");
            $('#productPrice').val("");

        }
        $(document).ready(() => {
            $('#resetNum-modal-close').on('click', () => {
                $('#resetNum-modal').modal('hide');
            });


        });
    </script>
@endsection
