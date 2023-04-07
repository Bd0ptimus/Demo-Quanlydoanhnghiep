@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs d-flex justify-content-start" id="nav-tab" role="tablist">
                        <button class="nav-link active productTabs" id="nav-cost-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-cost" type="button" role="tab" aria-controls="nav-cost"
                            aria-selected="true">Chi phí</button>
                        <button class="nav-link productTabs" id="nav-costList-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-costList" type="button" role="tab" aria-controls="nav-costList"
                            aria-selected="false">Danh mục chi phí</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="position: relative;">
                    <div class="tab-pane fade show active" id="nav-cost" role="tabpanel"
                        aria-labelledby="nav-cost-tab" tabindex="0">
                        <div class="row d-flex justify-content-center" style="width:100%; margin: 30px auto;">
                            <h4 style="text-align:center; font-weight:700;">Chi phí</h4>

                            <div class="row" style="width : 200px;">
                                <a class="btn btn-primary"
                                    href="{{ route('admin.cost.addCost') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <i class="fa-solid fa-plus"></i><span> {{__('Add Cost')}}</span>
                                </a>
                            </div>
                            <div class="table-responsive" style="margin-top:20px;">
                                <table class="costTable"
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
                                            <th data-sortable="true"  scope="col">#</th>
                                            <th data-sortable="true"  scope="col">Ghi chú</th>
                                            <th data-sortable="true"  scope="col">Chi phí (&#8363;)</th>
                                            <th data-sortable="true"  scope="col">Ngày chi</th>
                                            <th data-sortable="true"  scope="col">Loại chi phí</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($costs as $key => $cost)
                                        {{-- {{dd( $cost->costType)}} --}}
                                            <tr>
                                                <td scope="col">{{ $key + 1 }}</td>
                                                <td scope="col">{{ $cost->note }}</td>
                                                <td scope="col">{{ number_format($cost->cost) }}</td>
                                                <td scope="col">{{$cost->date_pay?date('d-m-Y H:i:s', strtotime($cost->date_pay)):''}}</td>
                                                <td scope="col">
                                                    @if(isset($cost->costType))
                                                        {{$cost->costType->name}} - @if($cost->costType->cost_type ==FIXED_COST )Chi phí cố đinh @elseif($cost->costType->cost_type ==VARIABLE_COST) Chi phí biến đổi @endif
                                                    @else

                                                    @endif
                                                    </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-costList" role="tabpanel" aria-labelledby="nav-costList-tab"
                        tabindex="0">

                        <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                            <div class="row" style="width:100%; margin: 30px auto;">
                                <h4 style="text-align:center; font-weight:700;">Danh mục</h4>

                                <div class="row" style="width : 200px;">
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.cost.addCostType') }}">
                                        <i class="fa-solid fa-plus"></i><span> Thêm loại chi phí</span>
                                    </a>
                                </div>
                                <div class="table-responsive" style="margin-top:20px;">
                                    <table class="costTable"
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
                                                <th data-sortable="true"  scope="col">#</th>
                                                <th data-sortable="true"  scope="col">Tên chi phí</th>
                                                <th data-sortable="true"  scope="col">Loại chi phí</th>

                                                <th data-sortable="true"  scope="col">Thao tác</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($types as $key => $type)
                                                <tr>
                                                    <td scope="col">{{ $key + 1 }}</td>
                                                    <td scope="col">{{ $type->name }}</td>
                                                    <td scope="col">@if($type->cost_type == FIXED_COST) Chi phí cố định @elseif($type->cost_type == VARIABLE_COST) Chi phí biến đổi @endif</td>
                                                    <td scope="col">
                                                        <a class="btn btn-danger" href="{{route('admin.cost.deleteCostType',['costTypeId'=>$type->id])}}">
                                                            Xóa
                                                        </a>

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

                {{-- <div class="row">
                    <h6 class="webpage-title">{{__('Cost Manager') }}</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row" style="width : 200px;">
                            <a class="btn btn-primary"
                                href="{{ route('admin.cost.addCost') }}">
                                <i class="fa-solid fa-plus"></i><span> {{__('Add Cost')}}</span>
                            </a>
                        </div>
                        <div class="table-responsive" style="margin-top:20px;">
                            <table id="costTable"
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
                                        <th data-sortable="true"  scope="col">#</th>
                                        <th data-sortable="true"  scope="col">Ghi chú</th>
                                        <th data-sortable="true"  scope="col">Chi phí (&#8363;)</th>
                                        <th data-sortable="true"  scope="col">Ngày chi</th>
                                        <th data-sortable="true"  scope="col">Loại chi phí</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($costs as $key => $cost)
                                        <tr>
                                            <td scope="col">{{ $key + 1 }}</td>
                                            <td scope="col">{{ $cost->note }}</td>
                                            <td scope="col">{{ number_format($cost->cost) }}</td>
                                            <td scope="col">{{$cost->date_pay?date('d-m-Y H:i:s', strtotime($cost->date_pay)):''}}</td>
                                            <td scope="col">
                                                @if(isset($cost->costType))
                                                    {{$cost->costType->name}} - @if($cost->costType->cost_type ==FIXED_COST )Chi phí cố đinh @elseif($cost->costType->cost_type ==VARIABLE_COST) Chi phí biến đổi @endif
                                                @else

                                                @endif
                                                </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
        $(document).ready(function() {
            $('.costTable').bootstrapTable({
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

            let tabIndex = getCookie('tab');

            console.log('tab cookie : ', tabIndex);
            if (tabIndex == `{{ COST_TAB }}`) {
                resetTab();
                $('#nav-cost-tab').addClass('active');
                $('#nav-cost').addClass('active');
                $('#nav-cost').addClass('show');

            } else if (tabIndex == `{{ COSTLIST_TAB }}`) {
                resetTab();
                $('#nav-costList-tab').addClass('active');
                $('#nav-costList').addClass('active');
                $('#nav-costList').addClass('show');
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


            $('#nav-cost-tab').on('click', function() {
                console.log('tab changed');
                setCookie('tab', `{{ COST_TAB }}`, 30);
            });

            $('#nav-costList-tab').on('click', function() {
                console.log('tab changed');
                setCookie('tab', `{{ COSTLIST_TAB }}`, 30);

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
