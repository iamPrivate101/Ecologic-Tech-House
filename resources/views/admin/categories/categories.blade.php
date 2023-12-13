@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Categories</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                <h3 class="card-title">Categories</h3>
                                @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                                    <a style="max-width:150px;float:right; display:inline-block"
                                        href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-primary">
                                        Add Categories</a>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th class="d-none d-sm-table-cell">Parent Category</th>
                                            <th class="d-none d-sm-table-cell">URL</th>
                                            <th class="d-none d-sm-table-cell">Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-wrap">{{ $category['category_name'] }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap">
                                                    @if (isset($category['parentcategory']['category_name']))
                                                        {{ $category['parentcategory']['category_name'] }}
                                                    @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-wrap">{{ $category['url'] }}</td>
                                                <td class="d-none d-sm-table-cell text-wrap"> {{ date('F j, Y, g:i a', strtotime($category['created_at'])) }} </td>
                                                <td>
                                                    @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                                                        @if ($category['status'] == 1)
                                                            <a style="color:#3f6ed3" class="updateCategoryStatus"
                                                                id="category-{{ $category['id'] }}"
                                                                category_id="{{ $category['id'] }}"
                                                                href="javascript:void(0)">
                                                                <i class="fas fa-toggle-on" status="Active"></i>
                                                            </a>
                                                        @else
                                                            <a class="updateCategoryStatus"
                                                                id="category-{{ $category['id'] }}"
                                                                category_id="{{ $category['id'] }}" style="color: gray"
                                                                href="javascript:void(0)">
                                                                <i class="fas fa-toggle-off" status="Inactive"></i>
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;
                                                    @endif

                                                    @if ($categoriesModule['edit_access'] == 1 || $categoriesModule['full_access'] == 1)
                                                        <a style="color:#3f6ed3"
                                                            href="{{ url('admin/add-edit-category') . '/' . $category['id'] }}"><i
                                                                class="fas fa-edit"></i></a>
                                                        &nbsp;&nbsp;
                                                    @endif

                                                    @if ($categoriesModule['full_access'] == 1)
                                                        <a style="color:#3f6ed3" class="confirmDelete" name="Category"
                                                            title="Delete Category" href="javascript:void(0)"
                                                            record="category" record_id="{{ $category['id'] }}"><i
                                                                class="fas fa-trash"></i></a>
                                                    @endif

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
