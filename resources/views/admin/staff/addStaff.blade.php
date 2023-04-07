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
                                    <div class="card-header">{{ __('Add staff') }}</div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('admin.staff.addStaff') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="name"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<span
                                                        class="text-danger">(*)</span></label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                                        value="{{ old('name') }}" autocomplete="name" autofocus required>


                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="row mb-3">
                                                <label for="role"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Role') }}
                                                    <span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <select id="role" name='role'
                                                        class="form-control @error('role') is-invalid @enderror">
                                                        {{-- <option value="0" label="Chọn nhóm chức vụ..." selected="selected"> Chọn nhóm chức vụ...</option> --}}
                                                        @if (Admin::user()->inRoles([ROLE_TECH_ADMIN]))
                                                            <option value="{{ ROLE_CHEF }}"> Giám đốc</option>
                                                        @endif
                                                        @if (Admin::user()->inRoles([ROLE_CHEF, ROLE_TECH_ADMIN]))
                                                            <option value="{{ ROLE_MANAGER }}"> Quản lý</option>
                                                        @endif
                                                        <option value="{{ ROLE_STAFF }}" selected="selected"> Nhân viên
                                                        </option>

                                                    </select>

                                                    @error('role')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="immediateSuperior"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Immediate superior') }}
                                                    <span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <select id="immediateSuperior" name='immediateSuperior'
                                                        class="form-control @error('immediateSuperior') is-invalid @enderror">
                                                        <option value="0" label="Chọn cấp trên trực tiếp..."
                                                            selected="selected"> Chọn cấp trên trực tiếp...</option>
                                                        @foreach ($superiors as $superior)
                                                            <option value="{{ $superior->id }}">{{ $superior->name }} -
                                                                {{ $superior->position_title }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('immediateSuperior')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="positionTitle"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Position title') }}<span
                                                        class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="positionTitle" type="text"
                                                        class="form-control @error('positionTitle') is-invalid @enderror"
                                                        name="positionTitle" value="{{ old('positionTitle') }}"
                                                        autocomplete="positionTitle" autofocus required>

                                                    @error('positionTitle')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="dob"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of birth') }}
                                                    <span class="text-danger"></span></label>
                                                <div class="col-md-6">
                                                    <input id="dob" type="date"
                                                        class="form-control @error('dob') is-invalid @enderror"
                                                        name="dob" value="{{ old('dob') }}" autocomplete="dob"
                                                        autofocus>

                                                    @error('dob')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="shift"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Shift') }}
                                                </label>

                                                <div class="col-md-6">
                                                    <select class="js-example-basic-multiple form-control @error('shift') is-invalid @enderror" name="shift[]" multiple="multiple">
                                                        <option value="{{ SHIFT_MORNING }}">
                                                            {{ SHIFT_TEXT[SHIFT_MORNING] }}</option>
                                                        <option value="{{ SHIFT_AFTERNOON }}">
                                                            {{ SHIFT_TEXT[SHIFT_AFTERNOON] }}</option>
                                                        <option value="{{ SHIFT_EVENING }}">
                                                            {{ SHIFT_TEXT[SHIFT_EVENING] }}</option>
                                                    </select>

                                                    @error('shift')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="phone"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}
                                                    <span class="text-danger"></span></label>
                                                <div class="col-md-6">
                                                    <input id="phone" type="number"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        name="phone" value="{{ old('phone') }}" autocomplete="phone"
                                                        autofocus>

                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="salary"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Salary') }} theo giờ (VND)
                                                    <span class="text-danger"></span></label>
                                                <div class="col-md-6">
                                                    <input id="salary" type="number"
                                                        class="form-control @error('salary') is-invalid @enderror"
                                                        name="salary" value="{{ old('salary') }}" autocomplete="salary"
                                                        autofocus>

                                                    @error('salary')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="email"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}<span
                                                        class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" autocomplete="email"
                                                        autofocus required>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="password"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}<span
                                                        class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" value="{{ old('password') }}"
                                                        autocomplete="password" autofocus required>

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3 d-flex justify-content-center">
                                                <div class="col-md-1 col-form-label text-md-end">
                                                    <input class="form-check-input " type="checkbox" name="showPassword"
                                                        id="showPassword" style="width : 18px; height : 18px;">
                                                </div>
                                                <label for="showPassword"
                                                    class="col-md-6 col-form-label text-md-start">{{ __('Show Password') }}</label>
                                            </div>




                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Add staff') }}
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

@section('style')
    <link href="{{ asset('css/mobiscroll.jquery.min.css?v=') . time() }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
@endsection

@section('script2')
    <script type="text/javascript" src="{{ asset('js/mobiscroll.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(() => {
            $('.js-example-basic-multiple').select2();

            $('#multiple-shift').mobiscroll().select({
                inputElement: document.getElementById('shift'),
                touchUi: false
            });
            $('#showPassword').on('click', () => {
                let x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            });
        });
    </script>
@endsection
