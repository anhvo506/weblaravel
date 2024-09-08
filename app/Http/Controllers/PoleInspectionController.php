<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Tuyen;
use App\Models\TramBienAp;
use App\Models\DuongDayTrungThe;
use App\Models\NhanVien;
use App\Models\KiemTraTBA;
use App\Models\Nhom;
use App\Models\DonVi;
use App\Models\User;
use App\Models\Doi;

class PoleInspectionController extends Controller
{
    
 
    
    
    public function showNhom()
    {
        $nhoms = Nhom::all();
        $nhanViens = NhanVien::all(); 
        return view('indexNhom', compact('nhanViens', 'nhoms'));
    }

    

    
    
    //getTBAsByDuongDay
    public function getTBAsByDuongDay($duong_day_id)
    {
        // Lấy danh sách trạm biến áp theo đường dây
        $tramBienAps = TramBienAp::where('id_ddtt', $duong_day_id)->get();

        // Lấy thông tin đường dây để hiển thị
        $duongDay = DuongDayTrungThe::find($duong_day_id);

        return view('tramtheoduongday', compact('tramBienAps', 'duongDay'));
    }
    

    
    
   
    public function showForm()
    {

        $tuyens = Tuyen::with(['duongDayTrungThes', 'tramBienAps'])->get();


        return view('index', ['tuyens' => $tuyens]);
    }
    // public function showGroup()
    // {
    //     $nhoms = Nhom::with('nhanViens')->get();
    //     $allNhanViens = NhanVien::all(); 

    //     return view('indexGroup', compact('nhoms', 'allNhanViens'));
    // }

    public function addNhanVien(Request $request, $id)
    {
        $nhom = Nhom::findOrFail($id);
        $nhanVienId = $request->input('nhan_vien_id');

        // Cập nhật id_nhom của nhân viên để thêm vào nhóm
        $nhanVien = NhanVien::findOrFail($nhanVienId);
        $nhanVien->id_nhom = $nhom->id;
        $nhanVien->save();

        return redirect()->route('indexGroup')->with('success', 'Nhân viên đã được thêm vào nhóm thành công.');
    }

    public function showStaff()
    {
        $nhoms = Nhom::with('nhanViens')->get();
        $allNhanViens = NhanVien::all(); 

        return view('indexStaff', compact('nhoms', 'allNhanViens'));
    }

    
    public function edit($id)
    {
        $tuyen = Tuyen::findOrFail($id);

        $tramBienAps = $tuyen->tramBienAps;
        $duongDayTrungThes = $tuyen->duongDayTrungThes;

        return view('pole_inspection.editForm', compact('tuyen', 'tramBienAps', 'duongDayTrungThes'));
    }

    public function assignment(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'ten_nhan_vien' => 'required|string',
            'id' => 'required|exists:tram_bien_aps,id',
        ]);

        // Lấy thông tin trạm biến áp từ id
        $tramBienAp = TramBienAp::findOrFail($validatedData['id']);

        // Lấy id của nhân viên từ trạm biến áp
        $idNhanVien = $tramBienAp->id_nhan_vien;

        // Tìm nhân viên trong bảng nhan_viens
        $nhanVien = NhanVien::findOrFail($idNhanVien);
        $nhanVien->ten_nhan_vien = $validatedData['ten_nhan_vien'];
        $nhanVien->save();

        // Redirect back with success message
        return redirect()->route('admin.form')->with('success', 'Cập nhật tên nhân viên thành công');
    }
    
    public function update(Request $request, $id)
    {
        // Validate form data
        $validatedData = $request->validate([
            'ten_tuyen' => 'required|string',
            'tram_bien_ap.*.ten_tram' => 'required|string',
            'tram_bien_ap.*.dung_luong' => 'required|numeric',
            'duong_day_trung_the.*.ten_duong_day' => 'required|string',
            'duong_day_trung_the.*.tu_vi_tri_tru' => 'required|string',
            'duong_day_trung_the.*.den_vi_tri_tru' => 'required|string',
            'duong_day_trung_the.*.chieu_dai' => 'required|numeric',
        ]);

        // Tìm và cập nhật thông tin của tuyến
        $tuyen = Tuyen::findOrFail($id);
        $tuyen->ten_tuyen = $validatedData['ten_tuyen'];
        $tuyen->save();

        // Cập nhật thông tin TramBienAp
        foreach ($validatedData['tram_bien_ap'] as $tramBienApId => $tramBienApData) {
            $tramBienAp = TramBienAp::findOrFail($tramBienApId);
            $tramBienAp->ten_tram = $tramBienApData['ten_tram'];
            $tramBienAp->dung_luong = $tramBienApData['dung_luong'];
            $tramBienAp->save();
        }

        // Cập nhật thông tin DuongDayTrungThe
        foreach ($validatedData['duong_day_trung_the'] as $duongDayTrungTheId => $duongDayTrungTheData) {
            $duongDayTrungThe = DuongDayTrungThe::findOrFail($duongDayTrungTheId);
            $duongDayTrungThe->ten_duong_day = $duongDayTrungTheData['ten_duong_day'];
            $duongDayTrungThe->tu_vi_tri_tru = $duongDayTrungTheData['tu_vi_tri_tru'];
            $duongDayTrungThe->den_vi_tri_tru = $duongDayTrungTheData['den_vi_tri_tru'];
            $duongDayTrungThe->chieu_dai = $duongDayTrungTheData['chieu_dai'];
            $duongDayTrungThe->save();
        }

        // Redirect về trang danh sách tuyến sau khi cập nhật thành công
        return redirect()->route('admin.form')->with('success', 'Cập nhật thông tin tuyến thành công');
    }



    public function destroy($id)
{
    // Tìm đường dây trung thế cần xóa
    $duongDayTrungThe = DuongDayTrungThe::findOrFail($id);

    // Lấy tuyến mà đường dây trung thế này thuộc về
    $tuyen = $duongDayTrungThe->tuyen;

    // Xóa trạm biến áp liên quan đến đường dây trung thế
    foreach ($duongDayTrungThe->tramBienAps as $tramBienAp) {
        // Xóa kiểm tra TBA liên quan đến từng trạm biến áp
        if ($tramBienAp->kiemTraTBA) {
            $tramBienAp->kiemTraTBA->delete();
        }
        
        // Lấy nhân viên liên quan đến trạm biến áp
        $nhanVien = $tramBienAp->nhanVien;
        
        // Xóa trạm biến áp
        $tramBienAp->delete();
        
        // Nếu nhân viên không còn liên kết với bất kỳ trạm biến áp nào khác, xóa nhân viên
        if ($nhanVien && $nhanVien->tramBienAps()->count() === 0) {
            $nhanVien->delete();
        }
    }

    // Xóa đường dây trung thế
    $duongDayTrungThe->delete();

    // Kiểm tra xem tuyến còn tham chiếu đến đường dây trung thế nào khác không
    $otherDuongDayTrungTheCount = $tuyen->duongDayTrungThes()->where('id', '<>', $duongDayTrungThe->id)->count();

    // Nếu không còn đường dây trung thế nào khác tham chiếu đến tuyến này, xóa tuyến
    if ($otherDuongDayTrungTheCount === 0) {
        // Xóa tuyến
        $tuyen->delete();

        return redirect()->back()->with('success', 'Đã xóa đường dây trung thế, các trạm biến áp và tuyến liên quan thành công');
    }

    return redirect()->back()->with('success', 'Đã xóa đường dây trung thế và các trạm biến áp liên quan thành công');
}




    // public function store(Request $request)
    // {
    //     // Validate input data
    //     $request->validate([
    //         'ten_tuyen' => 'required|string|max:255',
    //         'ten_duong_day' => 'required|string|max:255',
    //         'tu_vi_tri_tru' => 'required|string|max:255',
    //         'den_vi_tri_tru' => 'required|string|max:255',
    //         'chieu_dai' => 'required|numeric',
    //         'ten_tram' => 'required|string|max:255',
    //         'dung_luong' => 'required|numeric',
    //     ]);
    
    //     $nhanVien = NhanVien::create([
    //         'ten_nhan_vien' => $request->ten_nhan_vien,
    //     ]);
        
                
    //     // Kiểm tra xem tên tuyến đã tồn tại trong database chưa
    //     $existingTuyen = Tuyen::where('ten_tuyen', $request->ten_tuyen)->first();
    
    //     if ($existingTuyen) {
    //         // Nếu tuyến đã tồn tại, cập nhật thông tin
    //         $existingTuyen->update([
    //             'ten_tuyen' => $request->ten_tuyen,
    //         ]);
    
    //         // Tạo mới DuongDayTrungThe cho tuyến (nếu chưa tồn tại)
    //         $duongDayTrungThe = DuongDayTrungThe::firstOrCreate([
    //             'ten_duong_day' => $request->ten_duong_day,
    //             'tu_vi_tri_tru' => $request->tu_vi_tri_tru,
    //             'den_vi_tri_tru' => $request->den_vi_tri_tru,
    //             'chieu_dai' => $request->chieu_dai,
    //             'tuyen_id' => $existingTuyen->id,
    //         ]);
    
    //         // Tạo mới KiemTraTBA
    //         $kiemTraTBA = KiemTraTBA::create([
    //             'gio_kiem_tra' => $request->gio_kiem_tra,
    //             'hien_tuong_bat_thuong' => $request->hien_tuong_bat_thuong,
    //             'ton_tai_da_xu_ly' => $request->ton_tai_da_xu_ly,
    //             'bien_phap_giai_quyet' => $request->bien_phap_giai_quyet,
    //         ]);

    //         // Tạo mới TramBienAp cho tuyến
    //         TramBienAp::create([
    //             'ten_tram' => $request->ten_tram,
    //             'dung_luong' => $request->dung_luong,
    //             'tuyen_id' => $existingTuyen->id,
    //             'id_ddtt' => $duongDayTrungThe->id,
    //             'id_nhan_vien' => $nhanVien->id,
    //             'id_kiem_tra' => $kiemTraTBA->id,
    //         ]);
    
    //         return redirect()->route('admin.form')->with('success', 'Thông tin tuyến đã được cập nhật thành công!');
    //     } else {
    //         // Nếu tuyến chưa tồn tại, tạo mới
    //         $newTuyen = Tuyen::create([
    //             'ten_tuyen' => $request->ten_tuyen,
    //         ]);
    
    //         // Tạo mới DuongDayTrungThe cho tuyến
    //         $duongDayTrungThe = DuongDayTrungThe::create([
    //             'ten_duong_day' => $request->ten_duong_day,
    //             'tu_vi_tri_tru' => $request->tu_vi_tri_tru,
    //             'den_vi_tri_tru' => $request->den_vi_tri_tru,
    //             'chieu_dai' => $request->chieu_dai,
    //             'tuyen_id' => $newTuyen->id,
    //         ]);
    
    //         // Tạo mới KiemTraTBA
    //         $kiemTraTBA = KiemTraTBA::create([
    //             'gio_kiem_tra' => $request->gio_kiem_tra,
    //             'hien_tuong_bat_thuong' => $request->hien_tuong_bat_thuong,
    //             'ton_tai_da_xu_ly' => $request->ton_tai_da_xu_ly,
    //             'bien_phap_giai_quyet' => $request->bien_phap_giai_quyet,
    //         ]);

    //         // Tạo mới TramBienAp cho tuyến
    //         TramBienAp::create([
    //             'ten_tram' => $request->ten_tram,
    //             'dung_luong' => $request->dung_luong,
    //             'tuyen_id' => $newTuyen->id,
    //             'id_ddtt' => $duongDayTrungThe->id,
    //             'id_nhan_vien' => $nhanVien->id,
    //             'id_kiem_tra' => $kiemTraTBA->id,
    //         ]);
    
    //         return redirect()->route('admin.form')->with('success', 'Tuyến mới đã được thêm thành công!');
    //     }
    // }
    
    

    public function createTram(Request $request)
    {
        // Validate input data
        $request->validate([
            'id_ddtt' => 'required|exists:duong_day_trung_thes,id',
            'ten_tram' => 'required|string|max:255',
            'dung_luong' => 'required|numeric',
        ]);
        $nhanVien = NhanVien::create([
            'ten_nhan_vien' => $request->ten_nhan_vien,
        ]);
        
        $duongDayTrungThe = DuongDayTrungThe::findOrFail($request->id_ddtt);

        // Lấy id_tuyen từ mối quan hệ
        $id_tuyen = $duongDayTrungThe->tuyen->id;

        // Tạo mới KiemTraTBA
        $kiemTraTBA = KiemTraTBA::create([
            'gio_kiem_tra' => $request->gio_kiem_tra,
            'hien_tuong_bat_thuong' => $request->hien_tuong_bat_thuong,
            'ton_tai_da_xu_ly' => $request->ton_tai_da_xu_ly,
            'bien_phap_giai_quyet' => $request->bien_phap_giai_quyet,
        ]);

        // Tạo mới TramBienAp với thông tin cần thiết
        $tramBienAp = TramBienAp::create([
            'tuyen_id' => $id_tuyen,
            'id_ddtt' => $request->id_ddtt,
            'ten_tram' => $request->ten_tram,
            'dung_luong' => $request->dung_luong,
            'id_nhan_vien' => $nhanVien->id,
            'id_kiem_tra' => $kiemTraTBA->id,
        ]);


        return redirect()->back()->with('success', 'Đã thêm trạm biến áp thành công');

    }
  

    public function showFormTest()
    {
        $tuyens = Tuyen::with(['duongDayTrungThes'])->get();
        return view('indexTest', ['tuyens' => $tuyens]);
    }

    
    public function createTest()
    {
        return view('test_TBA.addForm');
    }


public function createKiemTraTram(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'id_kiem_tra' => 'required|exists:kiem_tra_TBA,id', // Ensure id_kiem_tra exists in kiem_tra_tb_as table
        'gio_kiem_tra' => 'required',
        'hien_tuong_bat_thuong' => 'required',
        'ton_tai_da_xu_ly' => 'required',
        'bien_phap_de_nghi' => 'required',
        // 'id_tram_bien_ap' => 'required|exists:tram_bien_aps,id', // Ensure id_tram_bien_ap exists in tram_bien_aps table
    ]);

    // Find existing KiemTraTBA
    $kiemTraTBA = KiemTraTBA::findOrFail($validatedData['id_kiem_tra']);

    // Update KiemTraTBA instance
    $kiemTraTBA->update([
        'gio_kiem_tra' => $validatedData['gio_kiem_tra'],
        'hien_tuong_bat_thuong' => $validatedData['hien_tuong_bat_thuong'],
        'ton_tai_da_xu_ly' => $validatedData['ton_tai_da_xu_ly'],
        'bien_phap_de_nghi' => $validatedData['bien_phap_de_nghi'],
    ]);

    // Return redirect with success message
    return redirect()->route('test')->with('success', 'Kiểm tra trạm biến áp đã được cập nhật thành công.');
}

public function createNhanVien(Request $request)
{
    // Validate input
    $request->validate([
        'ten_nhan_vien' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        // Add more validation rules as needed
    ]);

    // Create a new user
    $user = User::create([
        'ten_dang_nhap' => $request->email, // Assuming ten_dang_nhap is the same as email
        'email' => $request->email,
        'password' => Hash::make($request->password),
        // Add other user fields as needed
    ]);

    // Create a new NhanVien associated with the user
    $nhanVien = NhanVien::create([
        'ten_nhan_vien' => $request->ten_nhan_vien,
        'id_user' => $user->id, // Assign the user_id to the NhanVien model
        // Add other NhanVien fields as needed
    ]);

    // Optionally, return a response or redirect
    return redirect()->route('nhanviens.index')->with('success', 'Nhân viên đã được tạo thành công.');
}
}
