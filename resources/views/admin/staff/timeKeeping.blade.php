@extends('layouts.app')
@php
    use App\Admin;
    use App\Models\User;
    use App\Models\Timesheet;

@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">{{ __('Timekeeping') }}</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    {{-- <div id='calendar'></div> --}}
                    <div class="row d-flex justify-content-center">
                        <input type="date" id="datePicked" name="datePicked" class="form-control"
                            value="{{ $datePicked }}" style="width:150px;;" />
                    </div>
                    <div class="row d-flex justify-content-center table-responsive"
                        style="overflow:scroll; margin:20px 0px;">
                        <table id="timesheetTable" data-search="true" data-show-columns="true" data-show-multi-sort="true"
                            data-pagination="true" data-show-jump-to="true" data-side-pagination="client"
                            data-mobile-responsive="true" data-check-on-init="true"
                            class="table table-bordered table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th data-sortable="true" scope="col">STT</th>
                                    <th data-sortable="true" scope="col">Tên</th>
                                    <th data-sortable="true" scope="col">Chức vụ</th>
                                    <th data-sortable="true" scope="col">Ca sáng</th>
                                    <th data-sortable="true" scope="col">Ca chiều</th>
                                    <th data-sortable="true" scope="col">Ca tối</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $key => $staff)
                                    <tr>
                                        <td scope="col">{{ $key + 1 }}</td>
                                        <td scope="col">{{ $staff->name ?? '' }}</td>
                                        <td scope="col">{{ $staff->position_title ?? '' }}</td>
                                        <td>

                                            <span>
                                                Tự động điền thời gian: <input type="checkbox"
                                                    id="morningshift-auto-{{ $staff->id }}"
                                                    onclick="autoFillTime({{ MORNING_SHIFT }},{{ $staff->id }})"
                                                    @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                            </span>
                                            <br>
                                            <span>

                                                <div class="d-flex justify-content-between">
                                                    <span>Từ : </span>
                                                    <input type="text" id="morningshift-start-{{ $staff->id }}"
                                                        class="form-control timeInput" style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->start_morning ?? '' }}"
                                                        data-shift="{{ MORNING_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{START_SHIFT}}"
                                                        data-id='morningshift-start-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ MORNING_SHIFT }}, {{ $staff->id }}, {{ START_SHIFT }}, 'morningshift-start-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <span>Đến : </span>
                                                    <input type="text" id="morningshift-end-{{ $staff->id }}"
                                                        class="form-control timeInput" style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->end_morning ?? '' }}"
                                                        data-shift="{{ MORNING_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{END_SHIFT}}"
                                                        data-id='morningshift-end-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ MORNING_SHIFT }}, {{ $staff->id }}, {{ END_SHIFT }}, 'morningshift-end-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>
                                            </span>


                                        </td>
                                        <td>
                                            <span>
                                                Tự động điền thời gian: <input type="checkbox"
                                                    id="afternoonshift-auto-{{ $staff->id }}"

                                                    onclick="autoFillTime({{ AFTERNOON_SHIFT }},{{ $staff->id }})"
                                                    @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                            </span>
                                            <br>
                                            <span>

                                                <div class="d-flex justify-content-between">
                                                    <span>Từ : </span>
                                                    <input type="text" id="afternoonshift-start-{{ $staff->id }}"
                                                        class="form-control timeInput" style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->start_afternoon ?? '' }}"
                                                        data-shift="{{ AFTERNOON_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{START_SHIFT}}"
                                                        data-id='afternoonshift-start-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ AFTERNOON_SHIFT }}, {{ $staff->id }}, {{ START_SHIFT }}, 'afternoonshift-start-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Đến : </span>
                                                    <input type="text" id="afternoonshift-end-{{ $staff->id }}"
                                                        class="form-control timeInput" style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->end_afternoon ?? '' }}"
                                                        data-shift="{{ AFTERNOON_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{END_SHIFT}}"
                                                        data-id='afternoonshift-end-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ AFTERNOON_SHIFT }}, {{ $staff->id }}, {{ END_SHIFT }},'afternoonshift-end-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>
                                            </span>

                                        </td>
                                        <td>
                                            <span>
                                                Tự động điền thời gian: <input type="checkbox"
                                                    id="eveningshift-auto-{{ $staff->id }}"
                                                    onclick="autoFillTime({{ EVENING_SHIFT }},{{ $staff->id }})"
                                                    @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                            </span>
                                            <br>
                                            <span>
                                                <div class="d-flex justify-content-between">
                                                    <span>Từ : </span>
                                                    <input type="text" id="eveningshift-start-{{ $staff->id }}"
                                                        class="form-control timeInput"  style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->start_evening ?? '' }}"
                                                        data-shift="{{ EVENING_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{START_SHIFT}}"
                                                        data-id='eveningshift-start-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ EVENING_SHIFT }}, {{ $staff->id }}, {{ START_SHIFT }}, 'eveningshift-start-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Đến : </span>
                                                    <input type="text" id="eveningshift-end-{{ $staff->id }}"
                                                        class="form-control timeInput" style="width:80%;"
                                                        value="{{ Timesheet::where('user_id', $staff->id)->where('date', $datePicked)->first()->end_evening ?? '' }}"
                                                        data-shift="{{ EVENING_SHIFT }}"
                                                        data-staff = "{{ $staff->id }}"
                                                        data-start-end="{{END_SHIFT}}"
                                                        data-id='eveningshift-end-{{ $staff->id }}'
                                                        onchange="timeOnChange({{ EVENING_SHIFT }}, {{ $staff->id }}, {{ END_SHIFT }},'eveningshift-end-{{ $staff->id }}')"
                                                        @if (!Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER, ROLE_TECH_ADMIN])) disabled @endif />
                                                </div>
                                            </span>

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
@endsection
@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>

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

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
@endsection
@section('script2')
    <script type="text/javascript">
        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         plugins: [ 'interaction'],
        //         locale: 'vi',
        //         initialView: 'dayGridMonth',
        //         selectable: true,
        //         select: function(start, end, jsEvent, view) {
        //             console.log('abc');
        //         },
        //     });
        //     calendar.render();
        // });

        function updateTimesheet(userId, value, shift, startEnd, elementId) {
            let urlPost = `{{ route('admin.staff.timekeeping.updateTime') }}`;
            $.ajax({
                method: 'post',
                url: urlPost,
                data: {
                    shift: shift,
                    time: value,
                    startEnd: startEnd,
                    date: `{{ $datePicked }}`,
                    userId: userId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('data response : ', JSON.stringify(data));
                    if (data.error == 0) {
                        $(`#${elementId}`).val(value);
                    }
                }

            });
        }

        function timeOnChange(shiftIndex, id, startEnd, elementId) {
            console.log('time on change : ', shiftIndex.toString() + '-' + id.toString() + '-' + startEnd.toString() + '-' +
                elementId + '-' + $(`#${elementId}`).val());
            updateTimesheet(id, $(`#${elementId}`).val(), shiftIndex, startEnd, elementId);

        }

        function autoFillTime(shiftIndex, id) {
            console.log(shiftIndex);


            if (shiftIndex == `{{ MORNING_SHIFT }}`) {
                if (!$(`#morningshift-auto-${id}`).prop('checked')) {
                    updateTimesheet(id, '', shiftIndex, '{{ START_SHIFT }}', `morningshift-start-${id}`);
                    updateTimesheet(id, '', shiftIndex, '{{ END_SHIFT }}', `morningshift-end-${id}`);
                } else {
                    updateTimesheet(id, `{{ MORNING_SHIFT_START }}`, shiftIndex, '{{ START_SHIFT }}',
                        `morningshift-start-${id}`);
                    updateTimesheet(id, `{{ MORNING_SHIFT_END }}`, shiftIndex, '{{ END_SHIFT }}',
                        `morningshift-end-${id}`);
                }

            } else if (shiftIndex == `{{ AFTERNOON_SHIFT }}`) {
                if (!$(`#afternoonshift-auto-${id}`).prop('checked')) {
                    updateTimesheet(id, '', shiftIndex, '{{ START_SHIFT }}', `afternoonshift-start-${id}`);
                    updateTimesheet(id, '', shiftIndex, '{{ END_SHIFT }}', `afternoonshift-end-${id}`);
                } else {
                    updateTimesheet(id, `{{ AFTERNOON_SHIFT_START }}`, shiftIndex, '{{ START_SHIFT }}',
                        `afternoonshift-start-${id}`);
                    updateTimesheet(id, `{{ AFTERNOON_SHIFT_END }}`, shiftIndex, '{{ END_SHIFT }}',
                        `afternoonshift-end-${id}`);
                }

            } else if (shiftIndex == `{{ EVENING_SHIFT }}`) {
                if (!$(`#eveningshift-auto-${id}`).prop('checked')) {
                    updateTimesheet(id, '', shiftIndex, '{{ START_SHIFT }}', `eveningshift-start-${id}`);
                    updateTimesheet(id, '', shiftIndex, '{{ END_SHIFT }}', `eveningshift-end-${id}`);
                } else {
                    updateTimesheet(id, `{{ EVENING_SHIFT_START }}`, shiftIndex, '{{ START_SHIFT }}',
                        `eveningshift-start-${id}`);
                    updateTimesheet(id, `{{ EVENING_SHIFT_END }}`, shiftIndex, '{{ END_SHIFT }}',
                        `eveningshift-end-${id}`);

                }

            }
        }


        $(document).ready(function() {
            $('.timeInput').datetimepicker({
                useCurrent: false,
                format: "HH:mm:ss"
            }).on('dp.change', function() {
                console.log('test change : ', $(this).attr('data-id'));
                timeOnChange($(this).attr('data-shift'), $(this).attr('data-staff'), $(this).attr('data-start-end'), $(this).attr('data-id'))
            });


            console.log('acb');
            $('#timesheetTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
                },
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


            $('#datePicked').on('change', function() {
                console.log('date changed');
                window.location.href = updateParameter(window.location.href, 'date', $('#datePicked').val());
            });
        });
    </script>
@endsection
