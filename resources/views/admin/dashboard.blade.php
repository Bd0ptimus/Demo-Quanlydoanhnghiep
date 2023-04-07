@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">{{ __('Overal Statistic') }}</h6>
                </div>
                <div class="row d-flex justify-content-center webpage-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3 d-block justify-content-center overall-statistic">
                            <div class="d-flex justify-content-start header-statistic">
                                {{ __('Total Income') }}
                            </div>
                            <div  class="d-flex justify-content-center main-statistic">
                                {{ number_format($totalIncome) }}<span style="font-size : 15px; font-weight : 500;">VND</span>
                            </div>
                        </div>

                        <div class="col-md-3 d-block justify-content-center overall-statistic">
                            <div class="d-flex justify-content-start header-statistic">
                                {{ __('Total Cost') }}
                            </div>
                            <div  class="d-flex justify-content-center main-statistic">
                                {{ number_format($totalCost) }}<span style="font-size : 15px; font-weight : 500;">VND</span>
                            </div>
                        </div>

                        <div class="col-md-3 d-block justify-content-center overall-statistic">
                            <div class="d-flex justify-content-start header-statistic">
                                Tổng lợi nhuận
                            </div>
                            <div  class="d-flex justify-content-center main-statistic">
                                {{ number_format($totalProfit) }}<span style="font-size : 15px; font-weight : 500;">VND</span>
                            </div>
                        </div>
                        {{-- <h6>
                            {{ __('Total Income') }} : <span style="font-weight:600;">{{ number_format($totalIncome) }}
                                VND</span>
                        </h6>
                        <h6>
                            {{ __('Total Cost') }} : <span style="font-weight:600;">{{ number_format($totalCost) }}
                                VND</span>
                        </h6>
                        <h6>
                            Tổng lợi nhuận : <span style="font-weight:600;">{{ number_format($totalProfit) }} VND</span>
                        </h6> --}}
                    </div>

                    <div class="row d-block justify-content-center my-5">
                        <div class="row" style="margin:0px;">
                            <h4 style="text-align:center; font-weight:bold;">
                                {{ __('Statistic') }}
                            </h4>
                        </div>
                        <div class="row d-flex justify-content-center" style="margin:10px 0px;">
                            <select class="form-control" style="width: auto;" id="statisticalChoice">
                                <option value="{{ STATISTIC_FOLLOW_MONTH }}"
                                    @if ($statistical == STATISTIC_FOLLOW_MONTH) selected @endif>Thống kê theo tháng</option>
                                <option value="{{ STATISTIC_FOLLOW_YEAR }}"
                                    @if ($statistical == STATISTIC_FOLLOW_YEAR) selected @endif>Thống kê theo năm</option>

                            </select>
                        </div>
                        <div class="row justify-content-center" id="statistic-charts" style="margin:0px; width:100%; padding:0px;">
                            <div class="d-block justify-content-center statistic-chart">
                                <div id="incomeCostProfit-chart" style="width:100%; height:90%;"></div>
                                <h4 style="font-weight:600; font-size: 15px; text-align:center; margin-top:10px;" class="chart-title">Đồ thị
                                    tăng trưởng lợi nhuận</h4>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="row">
                        <h4 style="text-align:center; font-weight:bold;">
                            {{ __('Order Table') }}
                        </h4>
                        <div class="table-responsive" style="margin-top:20px;">
                            <table id="invoiceTable" data-search="true" data-show-columns="true" data-show-multi-sort="true"
                                data-pagination="true" data-show-jump-to="true" data-side-pagination="client"
                                data-mobile-responsive="true" data-check-on-init="true">
                                <thead>
                                    <tr>
                                        <th data-sortable="true" scope="col">#</th>
                                        <th data-sortable="true" scope="col">Đơn hàng</th>
                                        <th data-sortable="true" scope="col">Tổng số tiền (VND)</th>
                                        <th data-sortable="true" scope="col">Nhân viên xử lý</th>
                                        <th data-sortable="true" scope="col">Thời gian tạo</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $key => $invoice)
                                        <tr>
                                            <td scope="col">{{ $key + 1 }}</td>
                                            <td scope="col"> <a target="_blank"
                                                    href="{{ route('invoice.showInvoice', ['invoiceId' => $invoice->id]) }}">{{ '#' . $invoice->id }}</a>
                                            </td>
                                            <td scope="col">{{ number_format($invoice->pay_amount) }}</td>
                                            <td scope="col">{{ $invoice->user->name }}</td>
                                            <td scope="col">
                                                {{ $invoice->created_at ? date('d-m-Y H:i:s', strtotime($invoice->created_at)) : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
@endsection
@section('script4')
    @vite(['resources/sass/dashboard.scss'])
@endsection
@section('script')
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('script2')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#invoiceTable').bootstrapTable({
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
        });
    </script>
@endsection
@section('script3')
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawIncomeCostChart);
        // google.charts.setOnLoadCallback(drawIncomeProfitChart);

        function drawIncomeCostChart() {
            var data = google.visualization.arrayToDataTable(@json($incomeProfitCostData));

            var options = {

                legend: {
                    position: 'top',
                    alignment: 'end'
                },
                colors: ['#e63946', '#06d6a0', '#faa307'],

                seriesType: 'bars',
                series: {
                    2: {
                        type: 'line'
                    }
                },
                isStacked: true,
                backgroundColor: '#f8fafc',
                // bar: { groupWidth: "90%" }

            };

            var chart = new google.visualization.ColumnChart(document.getElementById('incomeCostProfit-chart'));

            chart.draw(data, options);
        }



        $(document).ready(function() {
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


            $('#statisticalChoice').on('change', function() {
                window.location.href = updateParameter(window.location.href, 'statistical', $(
                        '#statisticalChoice')
                    .val());
            });
        });
    </script>
@endsection
