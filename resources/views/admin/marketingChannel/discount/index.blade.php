@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h6 class="webpage-title">Mã giảm giá sản phẩm</h6>
                </div>
                <div class="row d-flex justify-content-center" style="margin : 10px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 10px auto;">
                        <div class="row" style="width : 200px;">
                            <a class="btn" style="background-color:#F6412E;"
                                href="{{ route('admin.marketingChannel.discountProduct.addDiscountProduct') }}">
                                <i class="fa-solid fa-plus"></i><span> Tạo</span>
                            </a>
                        </div>
                        <div class="table-responsive" style="margin-top:20px;">
                            <table id="dataTable"
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
                                        <th data-sortable="true"  scope="col">Chương trình</th>
                                        <th data-sortable="true"  scope="col">Mã chương trình</th>
                                        <th data-sortable="true"  scope="col">Thời gian áp dụng</th>
                                        <th data-sortable="true"  scope="col">Sản phẩm áp dụng</th>

                                        <th data-sortable="true"  scope="col">Thao tác</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programs as $key => $program )
                                        <tr>
                                            <td scope="col">{{$key + 1 }}</td>
                                            <td scope="col">{{$program->name }}</td>
                                            <td scope="col">{{$program->program_code}}</td>
                                            <td scope="col">{{$program->start_date?date('d-m-Y H:i:s', strtotime($program->start_date)):''}} - {{$program->end_date?date('d-m-Y H:i:s', strtotime($program->end_date)):''}}</td>
                                            <td scope="col">
                                                @foreach($program->discountProductPrograms as $product)
                                                    {{$product->product->name}} <br>
                                                @endforeach
                                            </td>
                                            <td scope="col">
                                                <a class="btn btn-danger" href="{{route('admin.marketingChannel.deleteProgram',['programId'=>$program->id])}}">Xóa</a>
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
            $('#dataTable').DataTable( {
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
