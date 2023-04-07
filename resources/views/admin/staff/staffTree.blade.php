@extends('layouts.app')
@php
    use App\Admin;
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="width:100%; height:700px;" id="tree" />



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
    <script src={{ asset('js/orgChart/orgchart.js') }}></script>
    <script type="text/javascript">
        var chart = new OrgChart(document.getElementById("tree"), {
            menu: {
                pdf: {
                    text: "Xuất PDF"
                },
                png: {
                    text: "Xuất PNG"
                },
                svg: {
                    text: "Xuất SVG"
                },
                json: {
                    text: "Xuất JSON"
                }
            },
            nodeBinding: {
                field_0: "name",
                field_1: "title"

            },
            nodes: @json($userTreeData),
        });
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
