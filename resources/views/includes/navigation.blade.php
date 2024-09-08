<div class="offcanvas offcanvas-start sidebar_left show" tabindex="-1" id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header header_text">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Admin</h5>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1">
            <div class="form-floating">
              <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option selected value="1">Công Ty Điện Lực Sóc Trăng</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
              <label for="floatingSelect">Works with selects</label>
            </div>


            

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle p-2 bg-success nav_left" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-plus"></i>DỮ LIỆU HỆ THỐNG
              </a>
              <ul class="dropdown-menu show drop_left">
                <li><a class="dropdown-item" href="{{ route('donvi') }}">Đơn vị</a></li>
                <li><a class="dropdown-item" href="{{ route('phattuyen') }}">Phát tuyến</a></li>
                <li><a class="dropdown-item" href="{{ route('duongday') }}">Đường dây</a></li>
                <li><a class="dropdown-item" href="{{ route('tram') }}">Trạm biến áp</a></li>
                <li><a class="dropdown-item" href="{{ route('nhanvien') }}">Nhân viên</a></li>
                <li><a class="dropdown-item" href="{{ route('nhom') }}">Nhóm</a></li>
                <li><a class="dropdown-item" href="{{ route('doi') }}">Đội</a></li>
            
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle p-2 bg-success nav_left" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-plus"></i>KIỂM TRA
              </a>
              <ul class="dropdown-menu show drop_left">
              <li><a class="dropdown-item" href="{{ route('kiemtratram') }}">Kiểm tra trạm</a></li>
              <li><a class="dropdown-item" href="{{ route('kiemtraduongday') }}">Kiểm tra đường dây</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              
              </ul>
            </li>
          </ul>
        </div>