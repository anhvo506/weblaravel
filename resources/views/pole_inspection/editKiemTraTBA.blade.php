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

      <div class="container-fluid mt-4 ml-3" style="    max-height: 593px;
    overflow-y: auto;">
        
      
        <form action="{{ route('updateKiemTraTBA', $kiemTraTBA->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="gio_kiem_tra" class="form-label">Giờ Kiểm Tra</label>
            <input type="datetime-local" class="form-control" id="gio_kiem_tra" name="gio_kiem_tra" value="{{ old('gio_kiem_tra', $kiemTraTBA->gio_kiem_tra) }}" required>
        </div>

        <div class="mb-3">
            <label for="hien_tuong_bat_thuong" class="form-label">Hiện Tượng Bất Thường</label>
            <textarea class="form-control" id="hien_tuong_bat_thuong" name="hien_tuong_bat_thuong">{{ old('hien_tuong_bat_thuong', $kiemTraTBA->hien_tuong_bat_thuong) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ton_tai_da_xu_ly" class="form-label">Tồn Tại Đã Xử Lý</label>
            <textarea class="form-control" id="ton_tai_da_xu_ly" name="ton_tai_da_xu_ly">{{ old('ton_tai_da_xu_ly', $kiemTraTBA->ton_tai_da_xu_ly) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="bien_phap_de_nghi" class="form-label">Biện Pháp Đề Nghị</label>
            <textarea class="form-control" id="bien_phap_de_nghi" name="bien_phap_de_nghi">{{ old('bien_phap_de_nghi', $kiemTraTBA->bien_phap_de_nghi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>





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