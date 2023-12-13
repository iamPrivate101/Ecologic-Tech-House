@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sub Admins</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Sub Admins</li>
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
                                <h3 class="card-title">Sub Admins</h3>
                                <a style="max-width:150px;float:right; display:inline-block"
                                    href="{{ url('admin/add-edit-subadmin') }}" class="btn btn-block btn-primary">
                                    Add Sub Admins</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="subadmins" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th class="d-none d-sm-table-cell">Email</th>
                                            <th class="d-none d-sm-table-cell">Mobile</th>
                                            <th class="d-none d-sm-table-cell">Type</th>
                                            <th class="d-none d-sm-table-cell">Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subadmins as $key => $subadmin)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td class="text-wrap">{{ $subadmin->name }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap">{{ $subadmin->email }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap">{{ $subadmin->mobile }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap">{{ $subadmin->type }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap"> {{ date('F j, Y, g:i a', strtotime($subadmin->created_at)) }} </td>
                                                <td>
                                                    @if ($subadmin->status == 1)
                                                        <a style="color:#3f6ed3" class="updateSubadminStatus"
                                                            id="subadmin-{{ $subadmin->id }}"
                                                            subadmin_id="{{ $subadmin->id }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->id }}"
                                                            subadmin_id="{{ $subadmin->id }}" style="color: gray"
                                                            href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                    &nbsp;&nbsp;
                                                    <a style="color:#3f6ed3"
                                                        href="{{ url('admin/add-edit-subadmin') . '/' . $subadmin->id }}"><i
                                                            class="fas fa-edit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a style="color:#3f6ed3" class="confirmDelete" name="Subadmin"
                                                        title="Delete Sub Admin" href="javascript:void(0)" record="subadmin"
                                                        record_id="{{ $subadmin->id }}"><i class="fas fa-trash"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a style="color:#3f6ed3"
                                                        href="{{ url('admin/update-role') . '/' . $subadmin->id }}"><i
                                                            class="fas fa-unlock"></i></a>
                                                    &nbsp;&nbsp;
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
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
