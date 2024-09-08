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

        <form action="{{ route('updatePhanCongNhom', $doi->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="ma_doi" class="form-label">Mã đội</label>
                <input type="text" name="ma_doi" class="form-control" id="ma_doi" value="{{ $doi->ma_doi }}" required>
            </div>
            <div class="mb-3">
                <label for="ten_doi" class="form-label">Tên đội</label>
                <input type="text" name="ten_doi" class="form-control" id="ten_doi" value="{{ $doi->ten_doi }}" required>
            </div>
            <div class="mb-3">
        <label for="nhom_ids" class="form-label">Nhóm</label>
        <div id="nhom_ids">
            @foreach($nhoms as $nhom)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="nhom_ids[]" value="{{ $nhom->id }}"
                        id="nhom_{{ $nhom->id }}" 
                        {{ in_array($nhom->id, $doi->nhoms->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="nhom_{{ $nhom->id }}">{{ $nhom->ten_nhom }}</label>
                </div>
            @endforeach
        </div>
    </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>

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