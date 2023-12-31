@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->

                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <!-- form start -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                @if (Session::has('success_message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success: </strong> {{ Session::get('success_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="post" name="productForm" id="productForm"
                                    @if (empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                                    @else
                                        action="{{ url('admin/add-edit-product') . '/' . $product['id'] }}" @endif
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category_id">Select Category*</label>
                                                    <select name="category_id" id="category_id" class="form-control" required>
                                                        <option value="">Select Product</option>
                                                        @foreach ($getCategories as $cat)
                                                            <option
                                                                @if (!empty(@old('category_id')) && $cat['id'] == @old('category_id')) selected
                                                                    @elseif (!empty($product['category_id']) && $product['category_id'] == $cat['id']) selected @endif
                                                                value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                                                            @if (!empty($cat['subcategories']))
                                                                @foreach ($cat['subcategories'] as $subcat)
                                                                    <option
                                                                        @if (!empty(@old('category_id')) && $subcat['id'] == @old('category_id')) selected
                                                                            @elseif (!empty($product['category_id']) && $product['category_id'] == $subcat['id']) selected @endif
                                                                        value="{{ $subcat['id'] }}">
                                                                        &nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcat['category_name'] }}
                                                                    </option>
                                                                    @if (!empty($subcat['subcategories']))
                                                                        @foreach ($subcat['subcategories'] as $subsubcat)
                                                                            <option
                                                                                @if (!empty(@old('category_id')) && $subsubcat['id'] == @old('category_id')) selected
                                                                                    @elseif (!empty($product['category_id']) && $product['category_id'] == $subsubcat['id']) selected @endif
                                                                                value="{{ $subsubcat['id'] }}">
                                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subsubcat['category_name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="brand_id">Select Brand*</label>
                                                    <select name="brand_id" class="form-control" id="brand_id" required>
                                                        <option value="">Select Brand</option>
                                                        @foreach ($getBrands as $brand)
                                                            <option value="{{ $brand['id'] }}"
                                                            @if (!empty(@old('brand_id')) && $brand['id'] == @old('brand_id'))
                                                                selected
                                                                @elseif (!empty($product['brand_id']) && $product['brand_id'] == $brand['id']) selected @endif>
                                                                {{ $brand['brand_name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_name">Product Name*</label>
                                                    <input type="text" class="form-control" name="product_name"
                                                        id="product_name" required
                                                        @if (!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ @old('product_name') }}" @endif
                                                        placeholder="Enter Product Name">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_weight">Product Weight</label>
                                                    <input type="text" class="form-control" name="product_weight"
                                                        id="product_weight"
                                                        @if (!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ @old('product_weight') }}" @endif
                                                        placeholder="Enter Product Weight">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_code">Product Code*</label>
                                                    <input type="text" class="form-control" name="product_code"
                                                        id="product_code" placeholder="Enter Product Code" required
                                                        @if (!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ @old('product_code') }}" @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="group_code">Group Code</label>
                                                    <input type="text" class="form-control" name="group_code"
                                                        id="group_code"
                                                        @if (!empty($product['group_code'])) value="{{ $product['group_code'] }}" @else value="{{ @old('group_code') }}" @endif
                                                        placeholder="Enter Group Code">
                                                </div>
                                            </div>

                                        </div>



                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_color">Product Color*</label>
                                                    <input type="text" class="form-control" name="product_color"
                                                        id="product_color" required
                                                        @if (!empty($product['product_color'])) value="{{ $product['product_color'] }}" @else value="{{ @old('product_color') }}" @endif
                                                        placeholder="Enter Product Color">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="family_color">Family Color*</label>
                                                    <select name="family_color" class="form-control" required>
                                                        <option value="">Select Main Color</option>
                                                        @foreach ($familyColors as $color)
                                                            <option value="{{ $color['color_name'] }}"
                                                                @if (!empty(@old('family_color')) && @old('family_color') == $color['color_name']) selected
                                                        @elseif (!empty($product['family_color']) && $product['family_color'] == $color['color_name']) selected @endif>
                                                                {{ $color['color_name'] }}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_discount">Product Discount</label>
                                                    <input type="number" class="form-control" name="product_discount"
                                                        id="product_discount"
                                                        step="any"
                                                        min="0"
                                                        @if (!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ @old('product_discount') }}" @endif
                                                        placeholder="Enter Product Discount">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_price">Product Price*</label>
                                                    <input type="number" class="form-control" name="product_price"
                                                        id="product_price"
                                                        required
                                                        step="any"
                                                        min="0"
                                                        @if (!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ @old('product_price') }}" @endif
                                                        placeholder="Enter Product Price">
                                                </div>
                                            </div>

                                        </div>



                                        <?php
                                        $has_product_attribute = count($product['attributes']);
                                        ?>

                                        @if($has_product_attribute > 0)
                                        <div class="form-group">
                                            <label for="product_attribute">Added Attribute</label>
                                            <table style="background-color: #2c2d2e" cellpadding="10" width="50%">
                                                <thead>
                                                    <tr>
                                                        <td>SN</td>
                                                        <td>Size</td>
                                                        <td>SKU</td>
                                                        <td>Price</td>
                                                        <td>Stock</td>
                                                        <td>Actions</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($product['attributes'] as $key => $attribute)
                                                        <input type="hidden" name="attributeId[]"
                                                            value="{{ $attribute['id'] }}">
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $attribute['size'] }}</td>
                                                            <td>{{ $attribute['sku'] }}</td>
                                                            <td>
                                                                <input style="width: 100px" type="number" name="updateprice[]"
                                                                    value="{{ $attribute['price'] }}">
                                                            </td>
                                                            <td>
                                                                <input style="width: 100px" type="number" name="updatestock[]"
                                                                    value="{{ $attribute['stock'] }}">
                                                            </td>
                                                            <td>
                                                                @if ($attribute['status'] == 1)
                                                                    <a style="color:#3f6ed3" class="updateAttributeStatus"
                                                                        id="attribute-{{ $attribute['id'] }}"
                                                                        attribute_id="{{ $attribute['id'] }}"
                                                                        href="javascript:void(0)">
                                                                        <i class="fas fa-toggle-on" status="Active"></i>
                                                                    </a>
                                                                @else
                                                                    <a class="updateAttributeStatus"
                                                                        id="attribute-{{ $attribute['id'] }}"
                                                                        attribute_id="{{ $attribute['id'] }}"
                                                                        style="color: gray" href="javascript:void(0)">
                                                                        <i class="fas fa-toggle-off"
                                                                            status="Inactive"></i>
                                                                    </a>
                                                                @endif
                                                                &nbsp;&nbsp;

                                                                <a style="color:#3f6ed3" class="confirmDelete"
                                                                    name="Attribute" title="Delete Attribute"
                                                                    href="javascript:void(0)" record="attribute"
                                                                    record_id="{{ $attribute['id'] }}"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        @endif

                                        <?php
                                        if($has_product_attribute > 0){
                                            $required_product_attribute = "";
                                        }else{
                                            $required_product_attribute = "required";
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label for="product_attribute">Add Attribute</label>
                                            <div class="field_wrapper">
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <input type="text" name="size[]" id="size"
                                                            class="form-control" value="" placeholder="Size" {{ $required_product_attribute }} />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="sku[]" id="sku"
                                                            class="form-control" value="" placeholder="SKU" {{ $required_product_attribute }} />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" name="price[]" id="price"
                                                            class="form-control"
                                                            step="any"
                                                            min="0"
                                                            value="" placeholder="Price" {{ $required_product_attribute }} />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" name="stock[]" id="stock"
                                                            step="any"
                                                            min="0"
                                                            class="form-control" value="" placeholder="Stock" {{ $required_product_attribute }} />
                                                    </div>

                                                    <div class="col-md-1">
                                                        <a href="javascript:void(0);" class="add_button"
                                                            title="Add field">
                                                            <i class="fas fa-plus fa-lg"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"
                                                        placeholder="Enter Product Description">{{ old('description') }}@if (!empty($product['description']))
{{ $product['description'] }}
@endif
</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <label for="wash_care">Wash Care</label>
                                                    <textarea class="form-control" id="wash_care" name="wash_care" rows="3"
                                                        placeholder="Enter Product Wash Care">{{ old('wash_care') }}@if (!empty($product['wash_care']))
{{ $product['wash_care'] }}
@endif
</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search_keywords">Search Keywords</label>
                                                    <textarea class="form-control" id="search_keywords" name="search_keywords" rows="3"
                                                        placeholder="Enter Product Search Keywords">{{ old('search_keywords') }}@if (!empty($product['search_keywords']))
{{ $product['search_keywords'] }}
@endif
</textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group ">
                                                    <label for="laptop">Laptop</label>
                                                    <select name="laptop" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($productsFilters['laptopArray'] as $laptop)
                                                            <option value="{{ $laptop }}"
                                                                @if (!empty(@old('laptop')) && @old('laptop') == $laptop) selected
                                                            @elseif (!empty($product['laptop']) && $product['laptop'] == $laptop) selected @endif>
                                                                {{ $laptop }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="computer">Computer</label>
                                                    <select name="computer" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($productsFilters['computerArray'] as $computer)
                                                            <option value="{{ $computer }}"
                                                                @if (!empty(@old('computer')) && @old('computer') == $computer) selected
                                                            @elseif (!empty($product['computer']) && $product['computer'] == $computer) selected @endif>
                                                                {{ $computer }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mobile">Mobile</label>
                                                    <select name="mobile" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($productsFilters['mobileArray'] as $mobile)
                                                            <option value="{{ $mobile }}"
                                                                @if (!empty(@old('mobile')) && @old('mobile') == $mobile) selected
                                                            @elseif (!empty($product['mobile']) && $product['mobile'] == $mobile) selected @endif>
                                                                {{ $mobile }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company">Company</label>
                                                    <select name="company" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($productsFilters['companyArray'] as $company)
                                                            <option value="{{ $company }}"
                                                                @if (!empty(@old('company')) && @old('company') == $company) selected
                                                            @elseif (!empty($product['company']) && $product['company'] == $company) selected @endif>
                                                                {{ $company }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="network">Network</label>
                                                    <select name="network" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($productsFilters['networkArray'] as $network)
                                                            <option value="{{ $network }}"
                                                                @if (!empty(@old('network')) && @old('network') == $network) selected
                                                            @elseif (!empty($product['network']) && $product['network'] == $network) selected @endif>
                                                                {{ $network }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="is_featured">Featured Item</label>
                                                    <input type="checkbox" name="is_featured" value="Yes"
                                                        @if (!empty($product['is_featured']) && $product['is_featured'] == 'Yes') checked @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="is_bestseller">Best Seller</label>
                                                    <input type="checkbox" name="is_bestseller" value="Yes"
                                                        @if (!empty($product['is_bestseller']) && $product['is_bestseller'] == 'Yes') checked @endif>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="product_video">Product Video [ 2 mb
                                                        ]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        @if (!empty($product['product_video']))
                                                            <a style="color:#3f6ed3" target="_blank"
                                                                href="{{ url('front/videos/products/') . '/' . $product['product_video'] }}">View
                                                                Video</a>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <a href="javascript:void(0)" style="color:#3f6ed3"
                                                                class="confirmDelete"
                                                                name="Delete Product Video                                              title="Delete
                                                                Product="javascript:void(0)" record="product-video"
                                                                record_id="{{ $product['id'] }}"><i
                                                                    class="fas fa-trash"></i></a>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" name="product_video"
                                                        id="product_video">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="product_images">Product Image [ 1040 * 1200 ]
                                                    </label>
                                                    <input type="file" class="form-control" name="product_images[]"
                                                        multiple="" id="product_images">
                                                    <div style="margin: 20px;">
                                                        <div style="display: flex; flex-wrap: wrap; gap: 20px;">

                                                            @foreach ($product['images'] as $image)
                                                                <div
                                                                    style="width: 150px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">

                                                                    <a target="_blank"
                                                                        href="{{ url('front/images/products/large/' . $image['image']) }}">
                                                                        <img style="width: 100%; height: auto; display: block; border-bottom: 2px solid #ddd;"
                                                                            src="{{ asset('front/images/products/small/' . $image['image']) }}"
                                                                            alt="Product Image">
                                                                    </a>

                                                                    <div style="padding: 10px; text-align: center;">
                                                                        <input type="hidden" name="image[]"
                                                                            value="{{ $image['image'] }}">
                                                                        <input type="text" name="image_sort[]"
                                                                            value="{{ $image['image_sort'] }}"
                                                                            style="width: 50px; text-align: center; margin-top: 10px;">

                                                                        <a href="javascript:void(0)"
                                                                            style="color: #3f6ed3; text-decoration: none; margin-left: 10px;"
                                                                            class="confirmDelete" title="Delete Product Image"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            record="product-image"
                                                                            record_id="{{ $image['id'] }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="meta_title">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta_title"
                                                        id="meta_title" placeholder="Enter Product Meta Title"
                                                        @if (!empty($product['meta_title'])) value="{{ $product['meta_title'] }}"
                                                    @else
                                                        value="{{ old('meta_title') }}" @endif>

                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <label for="meta_keywords">Meta Keywords</label>
                                                    <input type="text" class="form-control" name="meta_keywords"
                                                        id="meta_keywords" placeholder="Enter Product Meta Keywords"
                                                        @if (!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="meta_description">Meta Description</label>
                                                    <input type="text" class="form-control" name="meta_description"
                                                        id="meta_description" placeholder="Enter Product Meta Description"
                                                        @if (!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif>

                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                    <!-- /.card-body -->

                                    <div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
