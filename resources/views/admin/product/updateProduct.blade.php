@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row product-section d-flex justify-content-center">
                <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                    <div class="row" style="width:100%; margin: 30px auto;">
                        <div class="row justify-content-center my-4">
                            <div class="col-md-8">
                                <div class="card my-2">
                                    <div class="card-header">Chỉnh sửa sản phẩm</div>

                                    <div class="card-body">
                                        <form method="POST"
                                            action="{{ route('admin.product.updateProduct', ['productId' => $product->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-form-label text-md-end">Tên sản
                                                    phẩm<span class="text-danger">(*)</span></label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="{{ $product->name }}" required
                                                        autocomplete="name" autofocus>

                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                            </div>



                                            <div class="row mb-3">
                                                <label for="price" class="col-md-4 col-form-label text-md-end">Giá bán
                                                    (&#8363;)<span class="text-danger">(*)</span></label>
                                                <div class="col-md-6">
                                                    <input id="price" type="number"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        name="price" value="{{ $product->price }}" required
                                                        autocomplete="name" autofocus>

                                                    @error('price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="category"
                                                    class="col-md-4 col-form-label text-md-end">Nhóm sản phẩm
                                                </label>

                                                <div class="col-md-6">
                                                    <select class="selectSec form-control @error('category') is-invalid @enderror" name="category[]" multiple="multiple">
                                                        @foreach($categories as $category)
                                                            {{-- {{dd($category)}} --}}
                                                            <option value="{{$category->id}}" @if(($category->products->where('id', $product->id)->first())!==null) selected @endif>
                                                            {{ $category->category_name }}</option>
                                                        @endforeach

                                                        </select>
                                                    @error('category')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="description" class="col-md-4 col-form-label text-md-end">Mô
                                                    tả</label>
                                                <div class="col-md-6">
                                                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                                        name="description" value="{{ $product->description }}" autocomplete="name" autofocus>{{ $product->description }}
                                                    </textarea>

                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="description" class="col-md-4 col-form-label text-md-end">Ảnh mô
                                                    tả</label>
                                                <div class="col-md-6">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="upload-btn-wrapper">
                                                            <button class="normal-button" disabled><i
                                                                    class="fa-solid fa-upload"></i>
                                                                Upload ảnh mô tả</button>
                                                            <input type="file" multiple="multiple"
                                                                name="desPhotoUpload[]" placeholder="Choose image"
                                                                id="desPhotoUpload" class="normal-button"
                                                                style="width:170px;">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row d-flex justify-content-center">
                                                    <span class="text-danger" id="desPhotoUpload-warning"></span>
                                                </div>
                                                <div class="row d-flex justify-content-center"
                                                    id="desPhotoUpload-preview-sec">
                                                    @foreach ($images  as $key => $image)
                                                        <div class="preview-image-sec">
                                                            <img class="upload-image" src="{{ $image }}"
                                                                alt="logo upload">
                                                            <i class="previewImage-delete-icon fa-solid fa-square-xmark fa-xl"
                                                                onclick="removePreviewImageInMultiple({{ $key }}, 'desPhotoUpload-preview-sec', 'desPhotoUpload')"></i>
                                                        </div>
                                                    @endforeach
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
@endsection
@section('style')
    <link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>

    <script>
        var desPhotoExist = new DataTransfer();

        var takeFile = function(url) {
            return new Promise(async function(resolve, reject) {
                var err = 0;
                let response = await fetch(url);
                let data = await response.blob();
                let metadata = {
                    type: 'image/jpeg'
                };
                var fileName = url.split('/').pop();
                let file = new File([data], fileName, metadata);
                desPhotoExist.items.add(file);
                console.log('desPhotoExist in takeFile');
                if (response == null) {
                    reject('not ok');
                } else {
                    resolve('ok');
                }
            })

        }


        async function addExistedImgFromBackend() {
            var imagesExisted = @json($images);
            imagesExisted.forEach(function(e) {
                takeFile(e).then(function() {
                    console.log('desPhoto : ', desPhotoExist.files);
                    document.getElementById('desPhotoUpload').files = desPhotoExist.files;
                });
            })

        }

        function removePreviewImageInMultiple(index, idForRemove, inputId) {
            // //check delete
            // console.log("multiple file before delete: ");
            // const filecheck = document.getElementById(inputId).files;
            // for (let i = 0; i < filecheck.length; i++) {
            //     console.log('file before : ', filecheck[i]);
            // }

            // const dt = new DataTransfer()
            desPhotoExist = new DataTransfer();
            const input = document.getElementById(inputId)
            const {
                files
            } = input

            console.log('index for remove : ', index);
            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                if (index !== i) {
                    console.log('not remove i : ', i);
                    desPhotoExist.items.add(file) // here you exclude the file. thus removing it.
                }
            }
            console.log('desPhotoExist after remove : ', desPhotoExist.files);
            input.files = desPhotoExist.files;
            // desPhotoExist.files = dt.files;
            $(`#${idForRemove}`).empty();

            var newListFiles = $(`#${inputId}`).prop('files');
            for (let i = 0; i < newListFiles.length; i++) {
                let reader = new FileReader();

                reader.onload = (e) => {
                    console.log('check file multiple: ', i);
                    $(`#${idForRemove}`).append(`
                            <div class="preview-image-sec">
                                <img class="upload-image" src="${e.target.result}" alt="logo upload">
                                <i class="previewImage-delete-icon fa-solid fa-square-xmark fa-xl" onclick="removePreviewImageInMultiple(${i}, '${idForRemove}', '${inputId}')"></i>
                            </div>
                        `);
                }
                reader.readAsDataURL(newListFiles[i]);
            }


        }
        // $(document).ready(function() {
        //     console.log('load ready not sync');
        //     $('.selectSec').select2();
        // });


        $(document).ready(async function() {
            $('.selectSec').select2();

            await addExistedImgFromBackend();


            $('#desPhotoUpload').on('change', function() {
                console.log('desPhotoUpload on change');
                var filesTypesAccept = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                var filesAmount = this.files.length;
                $('#desPhotoUpload-preview-sec').empty();
                for (let i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    var extension = this.files[i].name.split('.').pop().toLowerCase();
                    fileExtensionAccept = filesTypesAccept.indexOf(extension) > -1;
                    if (fileExtensionAccept) {
                        fileSizeAccept = this.files[i].size < 15728640;
                        if (fileSizeAccept) {
                            desPhotoExist.items.add(this.files[i]);
                            $('#desPhotoUpload-warning').text('');
                        } else {
                            $('#desPhotoUpload-warning').text(
                                'Kích thước ảnh quá lớn! Mỗi ảnh được chọn phải có kích thước không lớn hơn 15mb.'
                            );
                        }
                    } else {
                        $('#desPhotoUpload-warning').text(
                            'Định dạng file không được chấp nhận! Chỉ chấp nhận ảnh JPG, JPEG, PNG, GIF, AVG.'
                        );
                    }
                }

                const input = document.getElementById('desPhotoUpload');

                input.files = desPhotoExist.files;
                var filesAdd = $(`#desPhotoUpload`).prop('files');
                for (let i = 0; i < filesAdd.length; i++) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        console.log('check file multiple: ', i);
                        $('#desPhotoUpload-preview-sec').append(`
                            <div class="preview-image-sec" >
                                <img class="upload-image" src="${e.target.result}" alt="logo upload">
                                <i class="previewImage-delete-icon fa-solid fa-square-xmark fa-xl" onclick="removePreviewImageInMultiple(${i}, 'desPhotoUpload-preview-sec', 'desPhotoUpload')"></i>
                            </div>
                        `);
                    }
                    reader.readAsDataURL(filesAdd[i]);
                }

                // //Test
                // console.log('file after append');
                // const filecheckafter = document.getElementById('desPhotoUpload').files;
                // for (let i = 0; i < filecheckafter.length; i++) {
                //     console.log('file append : ', filecheckafter[i]);
                // }

            });

        });
    </script>
@endsection
