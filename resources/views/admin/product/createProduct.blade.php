@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row product-section d-flex justify-content-center">
                    <div class="row d-flex justify-content-center" style="margin : 30px auto ;padding:0px;">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <h6 class="webpage-title">Thêm sản phẩm mới</h6>
                                </div>
                                <div class="row" style="width:100%; margin: 30px auto;">
                                    <form method="POST" action="{{ route('admin.product.addProduct') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Tên sản
                                                phẩm mới<span class="text-danger">(*)</span></label>

                                            <div class="col-md-6">
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name') }}" required
                                                    autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                        </div>

                                        <div class="row mb-3">
                                            <label for="price" class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Giá bán
                                                (&#8363;)<span class="text-danger">(*)</span></label>
                                            <div class="col-md-6">
                                                <input id="price" type="number"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    name="price" value="{{ old('price') }}" required
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
                                                class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Nhóm sản phẩm
                                            </label>

                                            <div class="col-md-6">
                                                <select class="selectSec form-control  @error('category') is-invalid @enderror" name="category[]" multiple="multiple">
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}">
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
                                            <label for="numItems" class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Số lượng mặt hàng trong các kho</label>
                                            <div class="col-md-6">
                                                <table class="productTable display white-space: word-wrap: break-word;">
                                                    <thead>
                                                        <tr>
                                                            <td data-sortable="true" scope="col">Kho hàng</td>
                                                            <td data-sortable="true" scope="col">Số lượng ở kho hàng</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($warehouses as $key => $warehouse)
                                                            <tr>
                                                                <td scope="col">{{ $warehouse->name }}</td>
                                                                <td scope="col"><input class="form-control" name="warehouse{{$warehouse->id}}" value="0"/></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                @error('numItems')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="description" class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Mô
                                                tả</label>
                                            <div class="col-md-6">
                                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}" autocomplete="name" autofocus>
                                                </textarea>

                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="description" class="col-md-4 col-form-label text-md-end" style="font-weight:700;">Ảnh mô tả</label>
                                            <div class="col-md-6">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="upload-btn-wrapper">
                                                        <button class="normal-button" disabled><i
                                                                class="fa-solid fa-upload"></i>
                                                            Upload ảnh mô tả</button>
                                                        <input type="file" multiple="multiple" name="desPhotoUpload[]"
                                                            placeholder="Choose image" id="desPhotoUpload"
                                                            class="normal-button" style="width:170px;">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row d-flex justify-content-center">
                                                <span class="text-danger" id="desPhotoUpload-warning"></span>
                                            </div>
                                            <div class="row d-flex justify-content-center"
                                                id="desPhotoUpload-preview-sec">

                                            </div>
                                        </div>



                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Thêm sản phẩm
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
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection
@section('script2')
<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.3/dist/bootstrap-table-locale-all.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>

@endsection
@section('script')

    <script type="text/javascript">
        var desPhotoExist = new DataTransfer();

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

            // //Test
            // console.log("multiple file after delete: ");
            // const filecheckafter = document.getElementById('desPhotoUpload').files;
            // for (let i = 0; i < filecheckafter.length; i++) {
            //     console.log('file before : ', filecheckafter[i]);
            // }
        }
        $(document).ready(function() {
            $('.selectSec').select2();
            $('.productTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(3)'
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/vi.json',
                },
                responsive: true
            });

            $('#desPhotoUpload').on('change', function() {
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
