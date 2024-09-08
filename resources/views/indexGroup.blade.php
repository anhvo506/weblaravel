<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />

    <title>Admin</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <style>
        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: white;
        }

        .modal-backdrop {
            opacity: 0.5 !important;
            background-color: rgba(0, 0, 0, 0.8) !important;
        }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            @include('includes.header')
            @include('includes.navigation')

            <div class="right_col" role="main">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Thông tin Nhóm </h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">
                            <table class="table">
    <thead>
        <tr>
            <th scope="col">Tên Nhóm</th>
            <th scope="col">Nhân viên</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($nhoms as $nhom)
            <tr>
                <td>{{ $nhom->ten_nhom }}</td>
                <td>
                    @foreach ($nhom->nhanViens as $nhanVien)
                        <p>{{ $nhanVien->ten_nhan_vien }}</p>
                    @endforeach
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal1{{ $nhom->id }}">
                        Thêm Nhân viên
                    </button>
                    <!-- Modal -->
                    <div class="modal" id="assignModal1{{ $nhom->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Thêm Nhân Viên cho Nhóm</h4>
                            
                            </div>
                            <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tên Nhân Viên</th>
                                                <th scope="col">Mã Nhân Viên</th>
                                                <th scope="col">Bộ Phận</th>
                                                <th scope="col">Chức Danh</th>
                                                <th scope="col">Bậc Thợ</th>
                                                <th scope="col">Bậc AT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nhom->nhanViens as $nhanVien)
                                                <tr>
                                                    <td>{{ $nhanVien->ten_nhan_vien }}</td>
                                                    <td>{{ $nhanVien->ma_nhan_vien }}</td>
                                                    <td>{{ $nhanVien->bo_phan }}</td>
                                                    <td>{{ $nhanVien->chuc_danh }}</td>
                                                    <td>{{ $nhanVien->bac_tho }}</td>
                                                    <td>{{ $nhanVien->bac_AT }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <form action="{{ route('addNhanVien', $nhom->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nhan_vien_id" class="form-label">Chọn Nhân Viên:</label>
                                            <select class="form-select" id="nhan_vien_id" name="nhan_vien_id" required>
                                                @foreach ($allNhanViens as $nhanVien)
                                                    <option value="{{ $nhanVien->id }}">{{ $nhanVien->ten_nhan_vien }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
                                    </form>
                                </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../js/main.js"></script>
    <script src="../../js/validate.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</body>

</html>