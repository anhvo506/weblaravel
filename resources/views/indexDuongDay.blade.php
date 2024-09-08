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
    <link rel="stylesheet" href="../../style.css">
    

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
        <a href="{{route('showCreateDuongDay')}}" class="border-shadow">

          <button type="button" class="btn btn-primary">Tạo mới</button>
          </a>
        </div>
        <form method="GET" action="{{ route('duongday') }}">
        <div class="mb-3">
            <label for="phat_tuyen_id" class="form-label">Chọn Phát Tuyến</label>
            <select class="form-select form-select-sm form_select" id="phat_tuyen_id" name="phat_tuyen_id" aria-label="Small select example">
                <option value="">Chọn Phát Tuyến</option>
                @foreach($phatTuyens as $phatTuyen)
                    <option value="{{ $phatTuyen->id }}" {{ $selectedPhatTuyenId == $phatTuyen->id ? 'selected' : '' }}>
                        {{ $phatTuyen->ten_tuyen }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">Tên Đường Dây</th>
                <th scope="col">Từ Vị Trí Trụ</th>
                <th scope="col">Đến Vị Trí Trụ</th>
                <th scope="col">Chiều Dài</th>
             
                <th scope="col">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($duongDayTrungThes as $duongDayTrungThe)
                <tr>
                    <td>{{ $duongDayTrungThe->ten_duong_day }}</td>
                    <td>{{ $duongDayTrungThe->tu_vi_tri_tru }}</td>
                    <td>{{ $duongDayTrungThe->den_vi_tri_tru }}</td>
                    <td>{{ $duongDayTrungThe->chieu_dai }}</td>
                 
                    <td>
                        <button type="button" class="btn btn-primary">
                        <a href="{{ route('showFormEditDuongDay', ['id' => $duongDayTrungThe->id, 'phat_tuyen_id' => $duongDayTrungThe->tuyen_id]) }}">Sửa</a>
                        </button>
                        <div class="d-inline-block">
                        <form action="{{ route('deleteDuongDay', $duongDayTrungThe->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đường dây này không?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Xóa</button>
                      </form>
                      </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


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