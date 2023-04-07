@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="watchProductAmount-modal" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">

            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center;  padding:0px 50px;">Số lượng sản phẩm ở các kho hàng</h4>
                <span id="watchProductAmount-modal-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2" style="font-weight:700;">Tên sản phẩm</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="100" style="border-colorsetupBorderColor" id="amountDetailProductName"
                                 type="text" class="form-control h-100" value="" disabled />
                        </div>
                    </div>



                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2" style="font-weight:700;">Số lượng mặt hàng trong các kho</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <table class="table-responsive display white-space: word-wrap: break-word;"
                                style="margin:0px; width:100%; padding:0px;">
                                <thead>
                                    <tr>
                                        <th data-sortable="true" scope="col">Kho hàng</th>
                                        <th data-sortable="true" scope="col">Số lượng ở kho hàng</th>
                                    </tr>
                                </thead>
                                <tbody id="amountDetailTable">

                                </tbody>
                            </table>
                        </div>


                    </div>
            </div>


        </div>
    </div>

</div>

@section('style2')
    <style>
        .number-field .btn {
            background: #000000;
            color: #ffffff;
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
<script type="text/javascript">
    function reloadTable(){
        // $('.amountTable').DataTable({
        //     rowReorder: {
        //         selector: 'td:nth-child(3)'
        //     },
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
        //     },
        //     responsive: true
        // });
    }

    function increaseItemResetForms() {
        $('#productName').val("");
        $('#productPrice').val("");
    }

    $(document).ready(() => {
        // $('.amountTable').DataTable({
        //     rowReorder: {
        //         selector: 'td:nth-child(3)'
        //     },
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
        //     },
        //     responsive: true
        // });
        $('#watchProductAmount-modal-close').on('click', () => {
            console.log('click');
            $('#watchProductAmount-modal').modal('hide');
        });


    });
</script>
