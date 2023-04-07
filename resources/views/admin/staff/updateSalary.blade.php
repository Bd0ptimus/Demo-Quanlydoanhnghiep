@extends('layouts.app')

@section('content')
    @php
        use App\Admin;
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-8">
                                <div class="card my-2">
                                    <div class="card-header">Cập nhật lương cho {{$staff->name}} - {{$staff->position_title}}</div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('admin.staff.salary.updateSalary',['userId'=>$staff->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="salary"
                                                    class="col-md-4 col-form-label text-md-end">Lương tính theo giờ (VND)<span
                                                        class="text-danger">(*)</span></label>

                                                <div class="col-md-6">
                                                    <input id="salary" type="number" class="form-control @error('salary') is-invalid @enderror" name="salary"
                                                        value="{{ $staff->staff->salary??0 }}" autocomplete="salary" autofocus required>


                                                    @error('salary')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>




                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Xác nhận
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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

