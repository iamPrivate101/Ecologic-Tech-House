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

                                <form method="post" name="brandForm" id="brandForm"
                                    @if (empty($brand['id'])) action="{{ url('admin/add-edit-brand') }}"
                                    @else
                                        action="{{ url('admin/add-edit-brand').'/'.$brand['id'] }}" @endif
                                        enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="brand_name">Brand Name*</label>
                                            <input type="text" class="form-control" name="brand_name" id="brand_name"
                                                placeholder="Enter Brand Name" required
                                                @if (!empty($brand['brand_name'])) value="{{ $brand['brand_name'] }}" @else value="{{ old('brand_name') }}"  @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand_image">Brand Image</label>
                                            <input type="file" class="form-control" name="brand_image" id="brand_image"  value="{{ old('brand_image') }}">
                                            @if (!empty($brand['brand_image']))
                                                <input type="hidden" name="current_image" id="current_image" value="{{ $brand['brand_image'] }}">
                                                <a target="_bank" href="{{ url('front/images/brands/'.$brand['brand_image']) }}">
                                                <img style="width: 100px; margin: 10px" src="{{ asset('front/images/brands/'.$brand['brand_image']) }}" alt="brand_image">
                                                </a>
                                                <a style="color:#3f6ed3;" class="confirmDelete" name="Brand"
                                                title="Delete Brand Image" href="javascript:void(0)" record="brand-image"
                                                record_id="{{ $brand['id'] }}" ><i
                                                    class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="brand_logo">Brand Logo</label>
                                            <input type="file" class="form-control" name="brand_logo" id="brand_logo"  value="{{ old('brand_logo') }}">
                                            @if (!empty($brand['brand_logo']))
                                                <input type="hidden" name="current_logo" id="current_logo" value="{{ $brand['brand_logo'] }}">
                                                <a target="_bank" href="{{ url('front/images/brands/'.$brand['brand_logo']) }}">
                                                <img style="width: 100px; margin: 10px" src="{{ asset('front/images/brands/'.$brand['brand_logo']) }}" alt="brand_logo">
                                                </a>
                                                <a style="color:#3f6ed3;" class="confirmDelete" name="Brand"
                                                title="Delete Brand Logo" href="javascript:void(0)" record="brand-logo"
                                                record_id="{{ $brand['id'] }}" ><i
                                                    class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="brand_discount">Brand Discount</label>
                                            <input type="number" class="form-control" name="brand_discount" id="brand_discount"
                                                placeholder="Enter Brand Discount"
                                                step="any"
                                                min="0"
                                                @if (!empty($brand['brand_discount'])) value="{{ $brand['brand_discount'] }}" @else value="{{ old('brand_discount') }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="url">Brand Url*</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                                placeholder="Enter Brand Url" required
                                                @if (!empty($brand['url'])) value="{{ $brand['url'] }}" @else value="{{ old('url') }}" @endif>
                                        </div>

                                        <!-- textarea -->
                                        <div class="form-group">
                                            <label for="description">Brand Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Brand Description">{{ old('description') }}@if (!empty($brand['description'])){{ $brand['description'] }}@endif</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" id="meta_title"
                                                placeholder="Enter Brand Meta Title"
                                            @if (!empty($brand['meta_title']))
                                                value="{{ $brand['meta_title'] }}"
                                            @else
                                                value="{{ old('meta_title') }}"
                                            @endif>

                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords" placeholder="Enter Brand Meta Keywords"
                                                @if (!empty($brand['meta_keywords'])) value="{{ $brand['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>

                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <input type="text" class="form-control" name="meta_description"
                                                id="meta_description" placeholder="Enter Brand Meta Description"
                                                @if (!empty($brand['meta_description'])) value="{{ $brand['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif>

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
