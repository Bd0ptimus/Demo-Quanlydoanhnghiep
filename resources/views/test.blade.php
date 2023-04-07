@extends('layouts/app')


@section('content')
    <div class="container">
        <table id="table"
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
                    <th  data-sortable="true">Name</th>
                    <th data-sortable="true">Stargazers</th>
                    <th  data-sortable="true">Forks</th>
                    <th  data-sortable="true">Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="col">dmm</td>
                    <td scope="col">dmmb</td>
                    <td scope="col">dmmc</td>
                    <td scope="col">dmmd</td>
                </tr>
                <tr>
                    <td scope="col">aaaaa</td>
                    <td scope="col">aaaaab</td>
                    <td scope="col">aaaaac</td>
                    <td scope="col">aaaaad</td>
                </tr>
                <tr>
                    <td scope="col">bbbba</td>
                    <td scope="col">bbbbab</td>
                    <td scope="col">bbbbac</td>
                    <td scope="col">bbbbad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>

                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr><tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr><tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr><tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
                <tr>
                    <td scope="col">cccca</td>
                    <td scope="col">ccccab</td>
                    <td scope="col">ccccac</td>
                    <td scope="col">ccccad</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection


@section('style')
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css" rel="stylesheet">

@endsection
@section('script')
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>

@endsection

@section('script3')
    <script>
        $(document).ready(function() {
            $('#table').bootstrapTable({
                showMultiSort: true,
                formatMultipleSort: function() {
                    return 'Sắp xếp';
                },
                formatCancel: ()=>{
                    return 'Hủy';
                },
                formatColumn:()=>{
                    return 'Cột';
                },
                formatDeleteLevel : ()=>{
                    return 'Xóa cấp sắp xếp';
                },
                formatOrder:()=>{
                    return 'Sắp xếp theo';
                },
                formatSort:()=>{
                    return 'Sắp xếp';
                },
                formatSortBy:()=>{
                    return 'Sắp xếp theo';
                },
                formatSortOrders:()=>{
                    return {
                        asc :  "Tăng dần",
                        desc: 'Giảm dần',
                    };
                },
                formatThenBy:()=>{
                    return 'Tiếp theo';
                },

                showJumpTo:false,
            })
        });
    </script>
@endsection
