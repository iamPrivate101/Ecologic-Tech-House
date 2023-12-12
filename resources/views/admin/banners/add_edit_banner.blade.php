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
                            <div class="col-6">
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

                                <form method="post" name="bannerForm" id="bannerForm"
                                    @if (empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}"
                                    @else
                                        action="{{ url('admin/add-edit-banner') . '/' . $banner['id'] }}" @endif
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="type">Banner Type</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="">Select</option>
                                                <option @if (!empty($banner['type']) && $banner['type']=="Slider") selected @endif value="Slider">Slider</option>
                                                <option @if (!empty($banner['type']) && $banner['type']=="Fix 1") selected @endif value="Fix 1">Fix 1</option>
                                                <option @if (!empty($banner['type']) && $banner['type']=="Fix 2") selected @endif value="Fix 2">Fix 2</option>
                                                <option @if (!empty($banner['type']) && $banner['type']=="Fix 3") selected @endif  value="Fix 3">Fix 3</option>
                                                <option @if (!empty($banner['type']) && $banner['type']=="Fix 4") selected @endif  value="Fix 4">Fix 4</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="banner_image">Banner Image</label>
                                            <input type="file" class="form-control" name="banner_image"
                                                id="banner_image" value="{{ old('banner_image') }}">
                                            @if (!empty($banner['image']))
                                                <input type="hidden" name="current_image" id="current_image"
                                                    value="{{ $banner['image'] }}">
                                                <a target="_bank"
                                                    href="{{ url('front/images/banners/' . $banner['image']) }}">
                                                    <img style="width: 100px; margin: 10px"
                                                        src="{{ asset('front/images/banners/' . $banner['image']) }}"
                                                        alt="banner_image">
                                                </a>

                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title"
                                                id="title" placeholder="Enter Title"
                                                @if (!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="alt">Alt</label>
                                            <input type="text" class="form-control" name="alt"
                                                id="alt" placeholder="Enter Alt"
                                                @if (!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="link">Banner Link*</label>
                                            <input type="text" class="form-control" name="link" id="link"
                                                placeholder="Enter Banner Link"
                                                @if (!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="sort">Banner Sort*</label>
                                            <input type="number" class="form-control" name="sort" id="sort"
                                                placeholder="Enter Banner Sort"
                                                @if (!empty($banner['sort'])) value="{{ $banner['sort'] }}" @else value="{{ old('sort') }}" @endif>
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
