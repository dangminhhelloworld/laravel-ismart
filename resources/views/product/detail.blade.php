@section('title', 'Chi Tiết Sản Phẩm')
@extends('layouts.home')

@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('getProductByCategory', $product->category->slug) }}"
                                title=""> {{ $product->category->name }}</a>
                        </li>
                        <li>
                            <a href="{{ route('detailProduct', $product->id) }}"
                                title=""> {{ $product->name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                <img id="zoom"
                                    src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg" />
                            </a>
                            <div id="list-thumb">
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                                <a href=""
                                    data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg"
                                    data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                    <img id="zoom"
                                        src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                                </a>
                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            <img src="public/images/img-pro-01.png" alt="">
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="desc">
                                {!! $product->description !!}
                            </div>
                            <div class="num-product">
                                <span class="title">Tình trạng: </span>
                                @if ($product->quantity == 0)
                                    <span class="status">Hết hàng</span>
                                @else
                                    <span class="status">Còn hàng</span>
                                @endif




                            </div>

                            @if ($product->sale_price > 0)
                                <p class="price">{{ number_format($product->sale_price, 0, '', '.') }}đ</p>
                            @else
                                <p class="price">{{ number_format($product->price, 0, '', '.') }}đ</p>
                            @endif
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <a href="{{ route('cart.add',$product->id) }}" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                            <a href="{{ route('cart.pay') }}" title="Thêm giỏ hàng" class="add-cart buy-now">Mua ngay</a>
                        </div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail">
                        {!! $product ->content !!}
                    </div>
                </div>
                <div class="section" id="same-category-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">

                          @foreach ($products_same as $product_same)
                          <li>
                            <a href="" title="" class="thumb">
                                <img src="{{ asset($product->images[0]->image_name) }}"
                                style="width: 133px ; height: 133px; object-fit: cover;">
                            </a>
                            <a href="" title="" class="product-name">{{ $product_same ->name }}</a>
                            <div class="price">

                                @if ($product->sale_price > 0)
                                    <span
                                        class="new">{{ number_format($product->sale_price, 0, '', '.') }}
                                        đ</span>
                                    <span class="old">{{ number_format($product->price, 0, '', '.') }}
                                        đ</span>
                                @else
                                    <span class="new"> {{ number_format($product->price, 0, '', '.') }}
                                        đ</span>
                                @endif



                            </div>

                        </li>

                          @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            <li>
                                <a href="?page=category_product" title="">Điện thoại</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="?page=category_product" title="">Iphone</a>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Samsung</a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="?page=category_product" title="">Iphone X</a>
                                            </li>
                                            <li>
                                                <a href="?page=category_product" title="">Iphone 8</a>
                                            </li>
                                            <li>
                                                <a href="?page=category_product" title="">Iphone 8 Plus</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Oppo</a>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Bphone</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Máy tính bảng</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">laptop</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Tai nghe</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Thời trang</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Đồ gia dụng</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Thiết bị văn phòng</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="public/images/banner.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('message'))
<script>
    Swal.fire({
        title: "Thành công",
        text: "{{ session('message') }}",
        icon: "success",
        showConfirmButton: true,
        confirmButtonText: "OK",

    });
</script>
@endif
@endpush
