@extends('admin.admin_master')

@section('admin')

<div class="container-full">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Brand list</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Brand English</th>
                                        <th>Brand Hindi</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $item)
                                    <tr>
                                        <td>{{ $item->brand_name_en }}</td>
                                        <td>{{ $item->brand_name_hin }}</td>
                                        <td>
                                            <img src="{{ asset($item->brand_image) }}" alt=""
                                                style="width: 70px; height: 40px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <a href="{{ route('brand.edit', $item->id) }}" class="btn btn-info" title="Edit Data" >
                                             <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="{{ route('brand.delete', $item->id) }}" id="delete" class="btn btn-danger" title="Delete Data">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <!-------- Add Brand Page  --------->
            <div class="col-lg-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Brand</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="{{ route('brand.store') }}" enctype="multipart/form-data" >
                            @csrf

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <h5>Brand Name English <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="brand_name_en" class="form-control">

                                            @error('brand_name_en')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Brand Name Hindi<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="brand_name_hin"  class="form-control">
                                            @error('brand_name_hin')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Brand Image <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="file" name="brand_image" class="form-control">
                                            @error('brand_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Add New" class="btn btn-rounded btn-primary mb-5">

                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>


@endsection
