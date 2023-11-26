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

                                <form method="post" name="categoryForm" id="categoryForm"
                                    @if (empty($category['id'])) action="{{ url('admin/add-edit-category') }}"
                                    @else
                                        action="{{ url('admin/add-edit-category').'/'.$category['id'] }}" @endif
                                        enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="category_name">Category Name(Parent Category)*</label>
                                            <input type="text" class="form-control" name="category_name" id="category_name"
                                                placeholder="Enter Category Name"
                                                @if (!empty($category['category_name'])) value="{{ $category['category_name'] }}" @else value="{{ old('category_name') }}"  @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_name">Category Level*</label>
                                            <select name="parent_id" id="parent_id" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="0" @if($category['parent_id']==0) selected="" @endif >Main Category</option>
                                                @foreach ($getCategories as $cat )
                                                    <option @if (isset($category['parent_id']) && $category['parent_id'] == $cat['id'])
                                                        selected =""
                                                    @endif value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                                                    @if (!empty($cat['subcategories']))
                                                        @foreach ($cat['subcategories'] as $subcat )
                                                            <option @if (isset($category['parent_id']) && $category['parent_id'] == $subcat['id'])
                                                                selected=""
                                                            @endif value="{{ $subcat['id'] }}">&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcat['category_name'] }}</option>
                                                            @if (!empty($subcat['subcategories']))
                                                                @foreach ($subcat['subcategories'] as $subsubcat )
                                                                    <option @if (isset($category['parent_id']) && $category['parent_id'] == $subsubcat['id'])
                                                                    selected=""
                                                                    @endif value="{{ $subsubcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subsubcat['category_name'] }}</option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_image">Category Image</label>
                                            <input type="file" class="form-control" name="category_image" id="category_image"  value="{{ old('category_image') }}">
                                            @if (!empty($category['category_image']))
                                                <a target="_bank" href="{{ url('front/images/categories/'.$category['category_image']) }}">
                                                <img style="width: 100px; margin: 10px" src="{{ asset('front/images/categories/'.$category['category_image']) }}" alt="category_image">
                                                </a>
                                                <a style="color:#3f6ed3;" class="confirmDelete" name="Category"
                                                title="Delete Category Image" href="javascript:void(0)" record="category-image"
                                                record_id="{{ $category['id'] }}" ><i
                                                    class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="category_discount">Category Discount</label>
                                            <input type="text" class="form-control" name="category_discount" id="category_discount"
                                                placeholder="Enter Category Discount"
                                                @if (!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="url">Category Url*</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                                placeholder="Enter Category Url"
                                                @if (!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif>
                                        </div>

                                        <!-- textarea -->
                                        <div class="form-group">
                                            <label for="description">Category Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Category Description">{{ old('description') }}@if (!empty($category['description'])){{ $category['description'] }}@endif</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" id="meta_title"
                                                placeholder="Enter Category Meta Title"
                                            @if (!empty($category['meta_title']))
                                                value="{{ $category['meta_title'] }}"
                                            @else
                                                value="{{ old('meta_title') }}"
                                            @endif>

                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords" placeholder="Enter Category Meta Keywords"
                                                @if (!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>

                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <input type="text" class="form-control" name="meta_description"
                                                id="meta_description" placeholder="Enter Category Meta Description"
                                                @if (!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif>

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
