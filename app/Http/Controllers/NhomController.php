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
use App\Models\Permission;

class NhomController extends Controller
{
    public function showNhom()
    {
        $nhoms = Nhom::with('nhanViens')->get();
        $allNhanViens = NhanVien::all(); 

        return view('indexNhom', compact('nhoms', 'allNhanViens'));
    }
// public function showCreateNhom()
// {
//     // Lấy danh sách nhân viên từ bảng nhanvien
//     $nhanViens = NhanVien::all();
    
//     return view('pole_inspection.addNhom', compact('nhanViens'));
// }
public function showCreateNhom()
{
    // Lấy tất cả các nhân viên chưa được gán cho nhóm nào
    $nhanViens = NhanVien::whereNull('id_nhom')->get();

    return view('pole_inspection.addNhom', compact('nhanViens'));
}



    // public function createNhom(Request $request)
    // {
    //      // Xác thực dữ liệu đầu vào
    //      $request->validate([
    //         'ten_nhom' => 'required|string|max:255',
    //         'thu_tu_nhom' => 'nullable|integer',
    //         'id_nhan_vien' => 'required|array', // Thay đổi để chấp nhận mảng
    //         'id_nhan_vien.*' => 'exists:nhanviens,id', // Kiểm tra từng giá trị trong mảng
    //     ]);

    //     // Tạo nhóm mới
    //     $nhom = Nhom::create([
    //         'ten_nhom' => $request->input('ten_nhom'),
    //         'thu_tu_nhom' => $request->input('thu_tu_nhom'),
    //     ]);

    //     // Liên kết nhân viên với nhóm
    //     $nhanVienIds = $request->input('id_nhan_vien', []);
    //     foreach ($nhanVienIds as $idNhanVien) {
    //         $nhanVien = NhanVien::find($idNhanVien);
    //         $nhanVien->id_nhom = $nhom->id;
    //         $nhanVien->save();
    //     }
    
    //     return redirect()->route('nhom')->with('success', 'Nhóm đã được tạo thành công!');
    // }
//     public function createNhom(Request $request)
// {
//     // Xác thực dữ liệu đầu vào
//     $request->validate([
//         'ten_nhom' => 'required|string|max:255',
//         'thu_tu_nhom' => 'nullable|integer',
//         'id_nhan_vien' => 'required|array', // Thay đổi để chấp nhận mảng
//         'id_nhan_vien.*' => 'exists:nhan_viens,id', // Kiểm tra từng giá trị trong mảng
//     ]);

//     // Tạo nhóm mới
//     $nhom = Nhom::create([
//         'ten_nhom' => $request->input('ten_nhom'),
//         'thu_tu_nhom' => $request->input('thu_tu_nhom'),
//     ]);

//     // Liên kết nhân viên với nhóm
//     $nhanVienIds = $request->input('id_nhan_vien', []);
//     foreach ($nhanVienIds as $idNhanVien) {
//         $nhanVien = NhanVien::find($idNhanVien);
//         if ($nhanVien) {
//             $nhanVien->id_nhom = $nhom->id;
//             $nhanVien->save();
//         }
//     }

//     return redirect()->route('nhom')->with('success', 'Nhóm đã được tạo thành công!');
// }
public function createNhom(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'ten_nhom' => 'required|string|max:255',
        'thu_tu_nhom' => 'nullable|integer',
        'id_nhan_vien' => 'nullable|array', // Thay đổi để không yêu cầu mảng
        'id_nhan_vien.*' => 'exists:nhan_viens,id', // Kiểm tra từng giá trị trong mảng nếu có
    ]);

    // Tạo nhóm mới
    $nhom = Nhom::create([
        'ten_nhom' => $request->input('ten_nhom'),
        'thu_tu_nhom' => $request->input('thu_tu_nhom'),
    ]);

    // Liên kết nhân viên với nhóm
    $nhanVienIds = $request->input('id_nhan_vien', []);
    foreach ($nhanVienIds as $idNhanVien) {
        $nhanVien = NhanVien::find($idNhanVien);
        if ($nhanVien) {
            $nhanVien->id_nhom = $nhom->id;
            $nhanVien->save();
        }
    }

    return redirect()->route('nhom')->with('success', 'Nhóm đã được tạo thành công!');
}
public function showFormEditNhom($id)
{
    // Lấy thông tin nhóm cần chỉnh sửa
    $nhom = Nhom::findOrFail($id);

    // Lấy tất cả các nhân viên chưa được gán cho nhóm nào hoặc thuộc về nhóm hiện tại
    $nhanViens = NhanVien::where(function ($query) use ($id) {
        $query->whereNull('id_nhom')
              ->orWhere('id_nhom', $id);
    })->get();

    // Truyền dữ liệu vào view
    return view('pole_inspection.editNhom', compact('nhom', 'nhanViens'));
}
public function deleteNhom($id)
{
    // Tìm nhóm theo ID
    $nhom = Nhom::findOrFail($id);

    // Cập nhật các nhân viên thuộc nhóm đó để không thuộc nhóm nào
    NhanVien::where('id_nhom', $id)->update(['id_nhom' => null]);

    // Xóa nhóm
    $nhom->delete();

    // Redirect với thông báo thành công
    return redirect()->route('nhom')->with('success', 'Nhóm đã được xóa thành công!');
}
    public function updateNhom(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ten_nhom' => 'required|string|max:255',
            'thu_tu_nhom' => 'nullable|integer',
            'id_nhan_vien' => 'nullable|array', // Thay đổi để không yêu cầu mảng
            'id_nhan_vien.*' => 'exists:nhan_viens,id', // Kiểm tra từng giá trị trong mảng nếu có
        ]);

        // Cập nhật nhóm
        $nhom = Nhom::findOrFail($id);
        $nhom->update([
            'ten_nhom' => $request->input('ten_nhom'),
            'thu_tu_nhom' => $request->input('thu_tu_nhom'),
        ]);

        // Xóa liên kết nhân viên cũ
        $nhom->nhanViens()->update(['id_nhom' => null]);

        // Liên kết nhân viên mới với nhóm
        $nhanVienIds = $request->input('id_nhan_vien', []);
        foreach ($nhanVienIds as $idNhanVien) {
            $nhanVien = NhanVien::find($idNhanVien);
            if ($nhanVien) {
                $nhanVien->id_nhom = $nhom->id;
                $nhanVien->save();
            }
        }

        return redirect()->route('nhom')->with('success', 'Nhóm đã được cập nhật thành công!');
    }
}