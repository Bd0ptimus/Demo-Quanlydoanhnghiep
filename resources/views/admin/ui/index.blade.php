@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 30px auto; padding:0px;">
                    <h3 class="d-flex justify-content-center" style="padding:0px;">
                        Quản lý giao diện
                    </h3>

                </div>
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row" style="width:100%; margin: 30px auto;">
                            <div class="row" style="width:100%; margin: 5px auto;">
                                <h5>Background</h5>
                            </div>
                            <form method="POST" action="{{ route('admin.ui.addBackground') }}" enctype="multipart/form-data">@csrf
                                <input type="file" name="background" class="form-control" />
                                <br>
                                <button type="submit" type="submit"  class="btn btn-primary">Xác nhận</button>

                            </form>
                        </div>


                        <br><br>
                        <div class="row" style="width:100%; margin: 30px auto;">
                            <div class="row" style="width:100%; margin: 5px auto;">
                                <h5>Header</h5>
                            </div>
                            <form method="POST" action="{{ route('admin.ui.addHeader') }}" enctype="multipart/form-data"> @csrf
                                <input type="file" name="header" class="form-control"  />
                                <br>
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </form>
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

        });


    </script>
@endsection
