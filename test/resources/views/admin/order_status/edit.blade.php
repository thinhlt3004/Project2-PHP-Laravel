@extends('admin_layout')
@section('admin_content')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Quản lý</a>
                </li>
                <li class="breadcrumb-item active">Trạng thái đơn hàng</li>
            </ol>
            <!-- /form -->
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-9 col-lg-6 control-label" for="name">Tên</label>
                    <div class="col-md-9 col-lg-6">
                        <input type="hidden" name="id" value="1" class="form-control">
                        <input name="name" id="name" type="text" value="Đã đặt hàng" class="form-control">
                    </div>
                </div>
                <div class="form-action">
                    <input type="submit" class="btn btn-primary btn-sm" value="Cập nhật" name="update">
                </div>
            </form>
            <!-- /form -->
        </div>
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Thầy Lộc 2017</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.content-wrapper -->
@endsection
