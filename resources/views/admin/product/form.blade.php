@extends('layouts.admin')
@section('title', ' Thao tác Sản phẩm')
@section('content')
    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.save') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ isset($product) ? 'Cập nhật Sản phẩm' : 'Thêm Sản phẩm' }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', isset($product) ? $product->name : 0) }}">


                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">

                            <label for="images">Hình ảnh Sản phẩm</label>
                            <input type="file" class="form-control filepond" id="images" name="images[]"
                                style="width: 291px;" multiple>
                            <div id="imagePreview"></div>
                            @if (isset($product))
                                @foreach ($images as $image)
                                    <img src="{{ asset($image->image_name) }}" alt="" srcset="" width="100px"
                                        class="listImage" style="margin: 20px 0">
                                @endforeach
                            @endif
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            @foreach ($errors->get('images.*') as $key => $messages)
                                @foreach ($messages as $message)
                                    <p class="text-danger">{{ $message }}</p>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="price">Giá Sản phẩm(Gốc)</label>
                            <input type="text" class="form-control" id="price" name="price"
                                value="{{ old('price', isset($product) ? $product->price : 0) }} ">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá Sản phẩm(Đã giảm)</label>
                            <input type="text" class="form-control" id="sale_price" name="sale_price"
                                value="{{ old('sale_price', isset($product) ? $product->sale_price : 0) }}   ">
                        </div>
                        <div class="form-group">
                            <label for="price">Số lượng:</label>
                            <input type="text" class="form-control" id="quantity" name="quantity"
                                value="{{ old('quantity', isset($product) ? $product->quantity : 0) }}  ">
                            @error('quantity')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục sản phảm</label>
                            <select name="category_id" id="category_id" class="custom-select form-control">
                                <option value="" selected disabled hidden>-- Chọn danh mục --</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}"
                                        {{ old('category_id', isset($product) ? ($product->category_id == $row->id ? 'selected' : '') : '') }}>
                                        {{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mô tả --}}
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description1" cols="30" rows="10">
                           {{ old('description', isset($product) ? $product->description : '') }} </textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Nọi dung --}}
                        <div class="form-group">
                            <label for="content"> Chi tiết</label>
                            <textarea name="content" id="content1" cols="30" rows="10">
                            {{ old('content', isset($product) ? $product->content : '') }}</textarea>
                            @error('content')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#description1',
            height: 200,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
        tinymce.init({
            selector: 'textarea#content1',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            let imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Xóa nội dung cũ nếu có

            let files = event.target.files; // Lấy danh sách file đã chọn
            if (files) {

                for (let i = 0; i < files.length; i++) {
                    let listImage = document.querySelectorAll('.listImage');
                    let file = files[i];
                    let reader = new FileReader();
                    listImage.forEach(image => image.remove());
                    reader.onload = function(e) {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px'; // Thiết lập kích thước ảnh
                        img.style.margin = '10px';
                        imagePreview.appendChild(img);
                    }

                    reader.readAsDataURL(file); // Đọc file dưới dạng URL
                }
            }
        });
    </script>
@endpush
