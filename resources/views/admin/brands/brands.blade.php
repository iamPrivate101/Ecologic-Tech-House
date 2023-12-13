@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Brands</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Brands</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success: </strong> {{ Session::get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Brands</h3>
                                @if ($brandsModule['edit_access'] == 1 || $brandsModule['full_access'] == 1)
                                    <a style="max-width:150px;float:right; display:inline-block"
                                        href="{{ url('admin/add-edit-brand') }}" class="btn btn-block btn-primary">
                                        Add Brands</a>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                 <div class="table-responsive">
                                <table id="brands" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th class="d-none d-sm-table-cell">URL</th>
                                            <th class="d-none d-sm-table-cell">Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $key => $brand)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-wrap">{{ $brand['brand_name'] }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap">{{ $brand['url'] }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap"> {{ date('F j, Y, g:i a', strtotime($brand['created_at'])) }} </td>
                                                <td>
                                                    @if ($brandsModule['edit_access'] == 1 || $brandsModule['full_access'] == 1)
                                                        @if ($brand['status'] == 1)
                                                            <a style="color:#3f6ed3" class="updateBrandStatus"
                                                                id="brand-{{ $brand['id'] }}"
                                                                brand_id="{{ $brand['id'] }}"
                                                                href="javascript:void(0)">
                                                                <i class="fas fa-toggle-on" status="Active"></i>
                                                            </a>
                                                        @else
                                                            <a class="updateBrandStatus"
                                                                id="brand-{{ $brand['id'] }}"
                                                                brand_id="{{ $brand['id'] }}" style="color: gray"
                                                                href="javascript:void(0)">
                                                                <i class="fas fa-toggle-off" status="Inactive"></i>
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;
                                                    @endif

                                                    @if ($brandsModule['edit_access'] == 1 || $brandsModule['full_access'] == 1)
                                                        <a style="color:#3f6ed3"
                                                            href="{{ url('admin/add-edit-brand') . '/' . $brand['id'] }}"><i
                                                                class="fas fa-edit"></i></a>
                                                        &nbsp;&nbsp;
                                                    @endif

                                                    @if ($brandsModule['full_access'] == 1)
                                                        <a style="color:#3f6ed3" class="confirmDelete" name="Brand"
                                                            title="Delete Brand" href="javascript:void(0)"
                                                            record="brand" record_id="{{ $brand['id'] }}"><i
                                                                class="fas fa-trash"></i></a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
