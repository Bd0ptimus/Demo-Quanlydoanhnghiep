@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">{{__('List Invoice') }}</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class ="d-block justify-content-center">
                            <div class="row" style="width : 200px;">
                                <a class="btn btn-danger"
                                    href="{{ route('admin.invoice.removeAllPendingInvoice') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <span> {{__('Cancel all pending invoice')}}</span>
                                </a>
                            </div>
                            <br>
                            <div class="row d-flex justify-content-center" >
                                <select class="form-control" id="statusSelect" style="width : auto; height:auto;">
                                    <option value="-1" @if($statusSelected == -1) selected  @endif>Tất cả</option>
                                    <option value="{{CHECKOUT_PENDING}}" @if($statusSelected == CHECKOUT_PENDING) selected  @endif>Chưa hoàn thành</option>

                                    <option value="{{CHECKOUT_DONE}}" @if($statusSelected == CHECKOUT_DONE) selected  @endif>Đã xuất</option>

                                    <option value="{{CHECKOUT_REMOVED}}" @if($statusSelected == CHECKOUT_REMOVED) selected  @endif>Đã hủy</option>

                                </select>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top:20px;">
                            <table id="invoiceTable"
                                data-search="true"
                                data-show-columns="true"
                                data-show-multi-sort="true"
                                data-pagination="true"
                                data-show-jump-to="true"
                                data-side-pagination="client"
                                data-mobile-responsive="true"
                                data-check-on-init="true"
                            >
                                <thead>
                                    <tr>
                                        <th data-sortable="true"  scope="col">STT</th>
                                        <th data-sortable="true"  scope="col">Mã số hóa đơn</th>
                                        <th data-sortable="true"  scope="col">Tổng số tiền (VND)</th>
                                        <th data-sortable="true"  scope="col">Nhân viên xử lý</th>
                                        <th data-sortable="true" scope="col">Thời gian tạo</th>
                                        <th data-sortable="true" scope="col">Trạng thái</th>

                                        <th scope="col">Thao tác</th>

                                    </tr>
                                </thead>
                                <tbody id="list">
                                    @foreach ($invoices as $key => $invoice)
                                        <tr >
                                            <td scope="col">{{ $key + 1 }}</td>
                                            <td scope="col"><a target="_blank"
                                                href="{{ route('invoice.showInvoice', ['invoiceId' => $invoice->id]) }}">{{ '#' . $invoice->id }}</a></td>
                                            <td scope="col">{{ number_format($invoice->pay_amount) }}</td>
                                            <td scope="col">{{ $invoice->user->name }}</td>
                                            <td>{{ $invoice->created_at ? date('d-m-Y H:i:s', strtotime($invoice->created_at)) : '' }}
                                            </td>
                                            <td scope="col">
                                                @if($invoice->status == CHECKOUT_PENDING)
                                                    <p style="color:orange">Chưa hoàn thành</p>
                                                @elseif($invoice->status == CHECKOUT_DONE)
                                                    <p style="color:green">Đã xuất</p>
                                                @else
                                                    <p style="color:red">Đã hủy</p>

                                                @endif
                                            </td>

                                            <td>
                                                @if($invoice->status == CHECKOUT_PENDING )
                                                    <a class="btn interact-btn" style="background-color:red;"
                                                        onclick="removeInvoice({{$invoice->id}})">
                                                        Hủy hóa đơn</a>
                                                    <br>



                                                @endif

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
    @include('layouts.confirmNotification')


@endsection
@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
@endsection
@section('script')
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.3/dist/bootstrap-table-locale-all.min.js"></script>

    @endsection
@section('script2')
    <script type="text/javascript">

        function removeInvoice(invoiceId){
            console.log('abc');
            let urlPost = `{{ route('admin.invoice.removeInvoiceList') }}`;

            $.ajax({
                    method: 'post',
                    url: urlPost,
                    data: {
                        invoiceId: invoiceId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        console.log('data response : ', JSON.stringify(data));
                        if (data.error == 0) {
                            // $('#list').remove();
                            // $('#list').append(data.data);
                            $('#toast-success-text').text('Hủy hóa đơn thành công');
                            $('#notification-fail').toast('hide');
                            $('#notification-success').toast('show');
                            window.location.reload();

                        }else{
                            $('#toast-fail-text').text('Hủy hóa đơn không thành công');
                            $('#notification-fail').toast('show');
                            $('#notification-success').toast('hide');

                        }
                    }

                });
        }

        function reloadTable(){
            $('#invoiceTable').bootstrapTable('refresh');
        }
        $(document).ready(function() {
            $('#invoiceTable').bootstrapTable({
                locale:'vi-VN',
                showMultiSort: true,
                formatMultipleSort: function() {
                    return 'Sắp xếp';
                },
                formatCancel: () => {
                    return 'Hủy';
                },
                formatColumn: () => {
                    return 'Cột';
                },
                formatDeleteLevel: () => {
                    return 'Xóa cấp sắp xếp';
                },
                formatAddLevel: () => {
                    return 'Thêm cấp sắp xếp';
                },
                formatOrder: () => {
                    return 'Sắp xếp theo';
                },
                formatSort: () => {
                    return 'Sắp xếp';
                },
                formatSortBy: () => {
                    return 'Sắp xếp theo';
                },
                formatSortOrders: () => {
                    return {
                        asc: "Tăng dần",
                        desc: 'Giảm dần',
                    };
                },
                formatThenBy: () => {
                    return 'Tiếp theo';
                },
                showJumpTo: false,

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


            $('#statusSelect').on('change', function() {
                window.location.href = updateParameter(window.location.href, 'status', $('#statusSelect')
                    .val());
            });
        });


    </script>
@endsection
