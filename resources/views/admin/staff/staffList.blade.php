@extends('layouts.app')
@php
    use App\Admin;
@endphp
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">{{ __('Staff List') }}</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        @if(Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER,ROLE_TECH_ADMIN]))
                            <div class="row" style="width : 200px;">
                                <a class="btn btn-primary" href="{{ route('admin.staff.addStaff') }}">
                                    {{-- href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}" --}}
                                    <i class="fa-solid fa-user-plus"></i><span> {{__('Add staff')}} </span>
                                </a>
                            </div>
                        @endif

                        <div style="margin-top:20px;">
                            <table id="staffTable"
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
                                        <th data-sortable="true" scope="col">STT</th>
                                        <th data-sortable="true" scope="col">Tên</th>
                                        <th data-sortable="true" scope="col">Chức vụ</th>
                                        <th data-sortable="true" scope="col">Ngày sinh</th>
                                        <th data-sortable="true" scope="col">Số điện thoại</th>
                                        <th data-sortable="true" scope="col">Email</th>
                                        @if(Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER,ROLE_TECH_ADMIN]))
                                            @if(Admin::user()->inRoles([ROLE_CHEF,ROLE_TECH_ADMIN]))
                                                <th data-sortable="true" scope="col">Mật khẩu</th>
                                            @endif
                                            <th data-sortable="true" scope="col">Lương theo giờ (VND)</th>
                                        @endif
                                        <th data-sortable="true" scope="col">Ca làm việc</th>
                                        <th data-sortable="true" scope="col">Trạng thái</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffs as $key => $staff)
                                        <tr>
                                            <td scope="col">{{ $key + 1 }}</td>
                                            <td scope="col">{{ $staff->name??'' }}</td>
                                            <td scope="col">{{ $staff->position_title??'' }}</td>
                                            <td scope="col">{{isset($staff->staff->dob)?date('d-m-Y H:i:s', strtotime($staff->staff->dob)):'' }}</td>
                                            <td scope="col">{{ $staff->staff->phone??''}}</td>
                                            <td scope="col">{{ $staff->email??''}}</td>

                                            @if(Admin::user()->inRoles([ROLE_CHEF, ROLE_MANAGER,ROLE_TECH_ADMIN]))
                                                @if(Admin::user()->inRoles([ROLE_CHEF,ROLE_TECH_ADMIN]))
                                                    <td scope="col">
                                                        <p id="userPassword-{{$staff->id}}" style="display:none;">{{ $staff->password_raw }}</p><i
                                                        class="fa-solid fa-copy fa-xl copy-icon" onclick="copyText('userPassword-{{$staff->id}}')"></i>
                                                    </td>
                                                @endif
                                                <td scope="col">{{number_format($staff->staff->salary??0)}}</td>

                                            @endif
                                            <th scope="col">
                                                @if(isset($staff->staff->shift))
                                                    @foreach(json_decode($staff->staff->shift) as $shift)
                                                        <p style="margin:0px;">{{SHIFT_TEXT[$shift]}}</p>
                                                    @endforeach
                                                @endif

                                                {{-- {{isset($staff->staff->shift)?SHIFT_TEXT[$staff->staff->shift]:''}} --}}


                                            </th>
                                            <th scope="col">{{isset($staff->status)?ACC_STATUS_TEXT[$staff->status]:''}}</th>


                                            {{-- <td>

                                                <a class="btn interact-btn" style="background-color:blue;"
                                                    href="{{ route('admin.product.updateProduct', ['productId' => $product->id]) }}">
                                                    Chỉnh sửa</a>
                                                <br>

                                                <a class="btn interact-btn" style="background-color:gray;"
                                                    href="{{ route('admin.product.printQrCode', ['productId' => $product->id]) }}"
                                                    target="_blank">
                                                    In mã QR cho các sản phẩm</a>
                                                <br>

                                                <a class="btn interact-btn" style="background-color:green;"
                                                    onclick="increaseItem({{ $product->id }}, '{{ $product->name }}', '{{ $product->productItems->count() }}')">
                                                    Thêm số lượng mặt hàng</a>
                                                <br>
                                                <a class="btn interact-btn" style="background-color:orange;"
                                                    onclick="resetItem({{ $product->id }}, '{{ $product->name }}', '{{ $product->productItems->count() }}')">
                                                    Đặt lại số lượng mặt hàng</a>
                                                <br>
                                                <a class="btn interact-btn" style="background-color:red;"
                                                    href="{{ route('admin.product.deleteProduct', ['productId' => $product->id]) }}">
                                                    Xóa</a>

                                            </td> --}}
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
        });

        function copyText(id) {
            console.log('on copy password : ', id);
            var copyText = document.getElementById(id).textContent;

            /* Create a temporary textarea element to hold the text */
            var tempTextArea = document.createElement("textarea");
            tempTextArea.value = copyText;
            document.body.appendChild(tempTextArea);

            /* Select the text in the temporary textarea */
            tempTextArea.select();

            /* Copy the text inside the temporary textarea to the clipboard */
            document.execCommand("copy");

            /* Remove the temporary textarea from the page */
            document.body.removeChild(tempTextArea);

        }
    </script>
@endsection
