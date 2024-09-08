<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    

</head>

<body>
  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid content-adjust" id="main-container">
      <div class="row bggreen" style="width: 100%;">
        <div class="col-1">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="col-9 header_left">
          <span class="text-start">Kiểm Tra Lưới Điện</span>
        </div>


        <div class="col-2 header_right dropdown">
          <a class="btn dropdown-toggle btn_dropdown" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fa-solid fa-user"></i> Công ty ĐL Sóc Trăng
          </a>

          <ul class="dropdown-menu dropmenu">
            <div class="drop">PB17 Công ty ĐL Sóc Trăng</div>
            <div class="btn_drop">
              <button type="button" class="btn btn-light">Hồ sơ</button>
              <button type="button" class="btn btn-light">Đăng xuất</button>
            </div>

          </ul>
        </div>

      </div>

      <div class="container-fluid mt-4 ml-3">
        <div class="col-12 mt-2 mb-2">
        <a href="{{ route('showCreateTuyen') }}" class="border-shadow">

          <button type="button" class="btn btn-primary">Tạo mới</button>
          </a>
        </div>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
            <th scope="col">Tên Tuyến</th>
                          <th scope="col">Tên Đường Dây</th>
                          <th scope="col">Từ Vị Trí Trụ</th>
                          <th scope="col">Đến Vị Trí Trụ</th>
                          <th scope="col">Chiều Dài</th>
                          <th scope="col">Tên Trạm Biến Áp</th>
                          <th scope="col">Dung Lượng</th>
                          <th scope="col">Thao tác</th>
                          <th scope="col">Tên nhân viên được phân công</th>
            </tr>
          </thead>
          <tbody>
          @foreach($tuyens as $tuyen)
    @foreach($tuyen->duongDayTrungThes as $duongDayTrungThe)
        @php
            $tramBienAps = $duongDayTrungThe->tramBienAps;
            $maxCount = max(1, $tramBienAps->count());
        @endphp
        @for($i = 0; $i < $maxCount; $i++)
            <tr>
                <td>
                    @if($i == 0)
                        {{ $tuyen->ten_tuyen }}
                    @endif
                </td>
                <td>
                    @if($i == 0)
                        {{ $duongDayTrungThe->ten_duong_day }}
                    @endif
                </td>
                <td>
                    @if($i == 0)
                        {{ $duongDayTrungThe->tu_vi_tri_tru }}
                    @endif
                </td>
                <td>
                    @if($i == 0)
                        {{ $duongDayTrungThe->den_vi_tri_tru }}
                    @endif
                </td>
                <td>
                    @if($i == 0)
                        {{ $duongDayTrungThe->chieu_dai }}
                    @endif
                </td>
                <td>
                    @if(isset($tramBienAps[$i]))
                        {{ $tramBienAps[$i]->ten_tram }}
                    @endif
                </td>
                <td>
                    @if(isset($tramBienAps[$i]))
                        {{ $tramBienAps[$i]->dung_luong }}
                    @endif
                </td>
                <td>
                    

                @if($i == 0)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal{{ $duongDayTrungThe->id }}">
                            Thêm Trạm Biến Áp
                        </button>

                        <div class="modal" id="assignModal{{ $duongDayTrungThe->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Thêm Trạm Biến Áp</h4>
                                        </div>
                                    <div class="modal-body">
                                        <form action="{{ route('createTramBienAp.createTram') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_ddtt" value="{{ $duongDayTrungThe->id }}">
                                            
                                            <div class="mb-3">
                                                <label for="ten_tram">Tên Trạm Biến Áp:</label>
                                                <input type="text" class="form-control" id="ten_tram" name="ten_tram" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="dung_luong">Dung Lượng:</label>
                                                <input type="number" class="form-control" id="dung_luong" name="dung_luong" required>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Thêm Trạm Biến Áp</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if( $i == 0)
                        <form action="{{ route('admin.edit', ['id' => $tuyen->id]) }}" method="GET">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Sửa đường dây</button>
                        </form>
                        <form action="{{ route('admin.destroy', ['id' => $duongDayTrungThe->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="fas fa-times"></i>  Xóa đường dây</button>
                        </form>
                    @endif
     
                </td>
                <td>
                @if(isset($tramBienAps[$i]))
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal1{{ $tramBienAps[$i]->id }}">
                    Phân công
                </button>

                <!-- The Modal -->
                <div class="modal" id="assignModal1{{ $tramBienAps[$i]->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Phân Công Nhân Viên</h4>
                            
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('assignments.assignment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tuyen_id" value="{{ $tuyen->id }}">
                                    <input type="hidden" name="id" value="{{ $tramBienAps[$i]->id }}">
                                    <div class="mb-3">
                                        <label for="employee_name" class="form-label">Tên nhân viên:</label>
                                        <input type="text" class="form-control" id="employee_name" name="ten_nhan_vien" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Lưu</button>
                                </form>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                    @if(isset($tramBienAps[$i]->nhanVien))
                        {{ $tramBienAps[$i]->nhanVien->ten_nhan_vien ?? 'Chưa phân công' }}
                    @else
                        Chưa phân công
                    @endif
                </td>
            </tr>
        @endfor
    @endforeach
@endforeach

        </table>

        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled">
              <a class="page-link">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>

      @include('includes.navigation')
      </div>

    </div>
  </nav>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var navbarToggler = document.querySelector('.navbar-toggler');
      var offcanvasNavbar = document.getElementById('offcanvasNavbar');
      var containerFluid = document.getElementById('main-container');
      var header_right = document.getElementsByClassName('header_right')[0];
      var dropmenu = document.getElementsByClassName('dropmenu')

      var nav_left = document.getElementsByClassName('nav_left')
      var drop_left = document.getElementsByClassName('drop_left')

      navbarToggler.addEventListener('click', function (event) {
        event.stopPropagation();
        offcanvasNavbar.classList.toggle('show');
        containerFluid.classList.toggle('content-adjust');
      });
      header_right.addEventListener('click', function (event) {
        dropmenu[0].style.display = dropmenu[0].style.display === 'block' ? 'none' : 'block';
      })

      nav_left[0].addEventListener('click', function (event) {
        drop_left[0].style.display = drop_left[0].style.display === 'block' ? 'none' : 'block';
      })
      nav_left[1].addEventListener('click', function (event) {
        drop_left[1].style.display = drop_left[1].style.display === 'block' ? 'none' : 'block';
      })
    });


  </script>
</body>

</html>