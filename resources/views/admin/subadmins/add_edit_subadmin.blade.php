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

                                @if (Session::has('error_message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error: </strong> {{ Session::get('error_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="post" name="subadminForm" id="subadminForm"
                                    @if (empty($subadmindata['id'])) action="{{ url('admin/add-edit-subadmin') }}"
                                    @else
                                        action="{{ url('admin/add-edit-subadmin') . '/' . $subadmindata['id'] }}" @endif
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input
                                                @if ($subadmindata['id'] != '') disabled="" style="background-color: #cccccc" @else required='' @endif
                                                type="email" class="form-control" name="email" id="email"
                                                placeholder="Enter Email"
                                                @if (!empty($subadmindata['email'])) value="{{ $subadmindata['email'] }}"
                                            @else
                                                value="{{ old('email') }}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Enter Password">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Name*</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Name"
                                                @if (!empty($subadmindata['name'])) value="{{ $subadmindata['name'] }}" @else value="{{ old('name') }}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Mobile*</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                placeholder="Enter Mobile"
                                                @if (!empty($subadmindata['mobile'])) value="{{ $subadmindata['mobile'] }}" @else value="{{ old('mobile') }}" @endif>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="image">Profile Image</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                placeholder="Admin Image">

                                            @if (!empty($subadmindata['image']))
                                                <a target="_blank"
                                                    href="{{ url('admin/images/photos/' . $subadmindata['image']) }}">View
                                                    Profile Pic</a>
                                                <input type="hidden" name="current_image" id="current_image"
                                                    value="{{ $subadmindata['image'] }}">
                                            @endif
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="form-group col-md-6">
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
