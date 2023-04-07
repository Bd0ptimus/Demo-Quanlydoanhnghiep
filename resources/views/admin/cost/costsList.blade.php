@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">Danh mục chi phí</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row" style="width : 200px;">
                            <a class="btn btn-primary"
                                href="{{ route('admin.cost.addCostType') }}">
                                <i class="fa-solid fa-plus"></i><span> Thêm loại chi phí</span>
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
    </div>
    </div>


@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">

@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js">
    </script>

    <script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js">
    </script>

    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js">
    </script>
@endsection
@section('script2')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#costTable').DataTable( {
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
                },
                responsive: true
            } );
        });


    </script>
@endsection
