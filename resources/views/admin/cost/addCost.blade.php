@extends('layouts.app')

@section('content')
@php
    use App\Models\CostType;
@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-8">
                                <div class="card my-2">
                                    <div class="card-header">Thêm chi phí</div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('admin.cost.addCost') }}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-form-label text-md-end">{{__('Note')}}<span class="text-danger"></span></label>

                                                <div class="col-md-6">
                                                    <textarea id="note" type="text"
                                                        class="form-control @error('note') is-invalid @enderror"
                                                        name="note" value="{{ old('note') }}"
                                                        autocomplete="note" autofocus>
                                                    </textarea>

                                                    @error('note')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                            </div>

                                            <div class="row mb-3">
                                                <label for="cost" class="col-md-4 col-form-label text-md-end">{{__('Cost')}}
                                                    (&#8363;)<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="cost" type="number"
                                                        class="form-control @error('cost') is-invalid @enderror"
                                                        name="cost" value="{{ old('cost') }}" required
                                                        autocomplete="name" autofocus>

                                                    @error('cost')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="datePay" class="col-md-4 col-form-label text-md-end">{{__('Pay Date')}}<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="datePay" type="datetime-local"
                                                        class="form-control @error('datePay') is-invalid @enderror"
                                                        name="datePay" value="0" autocomplete="datePay"
                                                        autofocus min=0 required>

                                                    @error('datePay')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="costType" class="col-md-4 col-form-label text-md-end">Loại chi phí<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <select id="costType" name='costType'
                                                        class="form-select @error('costType') is-invalid @enderror">
                                                        @foreach(CostType::get() as $costType)
                                                            <option value="{{ $costType->id}}">{{$costType->name}} - @if($costType->cost_type ==FIXED_COST )Chi phí cố đinh @elseif($costType->cost_type ==VARIABLE_COST) Chi phí biến đổi @endif</option>

                                                        @endforeach

                                                    </select>

                                                    @error('costType')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{__('Add Cost')}}
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

