@extends('layouts.app')
@php
    use App\Admin;
    use App\Models\TimeSheet;
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="d-flex justify-content-center" style="padding:0px;">
                            {{ __('Salary') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                            <div class="row" style="width:100%; margin: 30px auto;">
                                <div class="row d-flex justify-content-center">
                                    <input type="month" id="monthPicked" name="monthPicked" class="form-control"
                                        value="{{ $monthPicked }}" style="width:150px;;" />
                                </div>
                                <div style="margin-top:20px;">
                                    <table id="staffTable" data-search="true" data-show-columns="true"
                                        data-show-multi-sort="true" data-pagination="true" data-show-jump-to="true"
                                        data-side-pagination="client" data-mobile-responsive="true"
                                        data-check-on-init="true">
                                        <thead>
                                            <tr>
                                                <th data-sortable="true" scope="col">STT</th>
                                                <th data-sortable="true" scope="col">Tên</th>
                                                <th data-sortable="true" scope="col">Chức vụ</th>
                                                <th data-sortable="true" scope="col">Lương theo giờ (VND)</th>
                                                <th data-sortable="true" scope="col">Số giờ đã làm việc trong tháng này
                                                </th>
                                                <th data-sortable="true" scope="col">Lương hiện nhận (VND)</th>
                                                @if(!Admin::user()->isRole(ROLE_STAFF))
                                                    <th data-sortable="true" scope="col">Thao tác</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (Admin::user()->isRole(ROLE_STAFF))
                                                @php

                                                    $staffTimeSheets = TimeSheet::where('user_id', Admin::user()->id)
                                                        ->whereBetween('date', [Carbon::parse($monthPicked)->firstOfMonth(), Carbon::parse($monthPicked)->lastOfMonth()])
                                                        ->get();
                                                    $totalWorkedTime = 0;
                                                    foreach ($staffTimeSheets as $staffTimeSheet) {
                                                        $startShiftMorning = Carbon::parse($staffTimeSheet->start_morning);
                                                        $endShiftMorning = Carbon::parse($staffTimeSheet->end_morning);
                                                        $diff_in_morning = $startShiftMorning->diffInHours($endShiftMorning);

                                                        $startShiftAfternoon = Carbon::parse($staffTimeSheet->start_afternoon);
                                                        $endShiftAfternoon = Carbon::parse($staffTimeSheet->end_afternoon);
                                                        $diff_in_afternoon = $startShiftAfternoon->diffInHours($endShiftAfternoon);

                                                        $startShiftEvening = Carbon::parse($staffTimeSheet->start_evening);
                                                        $endShiftEvening = Carbon::parse($staffTimeSheet->end_evening);
                                                        $diff_in_evening = $startShiftEvening->diffInHours($endShiftEvening);

                                                        $totalWorkedTime = $totalWorkedTime + $diff_in_morning + $diff_in_afternoon + $diff_in_evening;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td scope="col">{{  1 }}</td>
                                                    <td scope="col">{{ Admin::user()->name ?? '' }}</td>
                                                    <td scope="col">{{ Admin::user()->position_title ?? '' }}</td>
                                                    <td scope="col">{{number_format( Admin::user()->staff->salary ?? 0) }}</td>
                                                    <td scope="col">{{ $totalWorkedTime ?? 0 }}</td>
                                                    <td scope="col">
                                                        {{ number_format(($totalWorkedTime ?? 0) * (Admin::user()->staff->salary ?? 0)) }}
                                                    </td>

                                                </tr>
                                            @else
                                                @foreach ($staffs as $key => $staff)
                                                    @php

                                                        $staffTimeSheets = TimeSheet::where('user_id', $staff->id)
                                                            ->whereBetween('date', [Carbon::parse($monthPicked)->firstOfMonth(), Carbon::parse($monthPicked)->lastOfMonth()])
                                                            ->get();
                                                        $totalWorkedTime = 0;
                                                        foreach ($staffTimeSheets as $staffTimeSheet) {
                                                            $startShiftMorning = Carbon::parse($staffTimeSheet->start_morning);
                                                            $endShiftMorning = Carbon::parse($staffTimeSheet->end_morning);
                                                            $diff_in_morning = $startShiftMorning->diffInHours($endShiftMorning);

                                                            $startShiftAfternoon = Carbon::parse($staffTimeSheet->start_afternoon);
                                                            $endShiftAfternoon = Carbon::parse($staffTimeSheet->end_afternoon);
                                                            $diff_in_afternoon = $startShiftAfternoon->diffInHours($endShiftAfternoon);

                                                            $startShiftEvening = Carbon::parse($staffTimeSheet->start_evening);
                                                            $endShiftEvening = Carbon::parse($staffTimeSheet->end_evening);
                                                            $diff_in_evening = $startShiftEvening->diffInHours($endShiftEvening);

                                                            $totalWorkedTime = $totalWorkedTime + $diff_in_morning + $diff_in_afternoon + $diff_in_evening;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td scope="col">{{ $key + 1 }}</td>
                                                        <td scope="col">{{ $staff->name ?? '' }}</td>
                                                        <td scope="col">{{ $staff->position_title ?? '' }}</td>
                                                        <td scope="col">{{ number_format($staff->staff->salary ?? 0) }}</td>
                                                        <td scope="col">{{ $totalWorkedTime ?? 0 }}</td>
                                                        <td scope="col">
                                                            {{ number_format(($totalWorkedTime ?? 0) * ($staff->staff->salary ?? 0)) }}
                                                        </td>
                                                        <td scope="col">
                                                            <a class="btn btn-primary" href="{{route('admin.staff.salary.updateSalary',['userId'=>$staff->id])}}">Cập nhật lương</a>
                                                        </td>



                                                    </tr>
                                                @endforeach
                                            @endif

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
@endsection
@section('script2')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#staffTable').bootstrapTable({
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

            })

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


            $('#monthPicked').on('change', function() {
                window.location.href = updateParameter(window.location.href, 'month', $('#monthPicked')
                    .val());
            });
        });
    </script>
@endsection
