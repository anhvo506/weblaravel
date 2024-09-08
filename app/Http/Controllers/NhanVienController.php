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

class NhanVienController extends Controller
{
    public function showNhanVien()
    {
        $nhanViens = NhanVien::with('user', 'permission')->get(); // Tải thông tin người dùng và quyền
        return view('indexNhanVien', compact('nhanViens'));
    }
    public function showCreateNhanVien()
    {
        $permissions = Permission::all();
        return view('pole_inspection.addNhanVien', compact('permissions'));
    }

    // public function createNhanVien(Request $request)
    // { 
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'ten_nhan_vien' => 'required|string|max:255',
    //         'ma_nhan_vien' => 'required|string|max:255',
    //         'bo_phan' => 'required|string|max:255',
    //         'chuc_danh' => 'required|string|max:255',
    //         'bac_tho' => 'required|string|max:255',
    //         'bac_AT' => 'required|string|max:255',
    //         'permissions' => 'array'
    //     ]);
    
    //     // Tạo người dùng mới
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);
    
    //     // Tạo thông tin nhân viên
    //     NhanVien::create([
    //         'ten_nhan_vien' => $request->ten_nhan_vien,
    //         'ma_nhan_vien' => $request->ma_nhan_vien,
    //         'bo_phan' => $request->bo_phan,
    //         'chuc_danh' => $request->chuc_danh,
    //         'bac_tho' => $request->bac_tho,
    //         'bac_AT' => $request->bac_AT,
    //         'id_user' => $user->id,
    //         'id_permission' => $request->permissions ? $request->permissions[0] : null,
    //     ]);
    
    //     // Gán quyền cho người dùng
    //     // if ($request->has('permissions')) {
    //     //     $user->permissions()->sync($request->permissions); // Sử dụng sync để cập nhật quyền
    //     // }
    //     // if ($request->has('permissions')) {
    //     //     $user->syncPermissions($request->permissions); // Sử dụng syncPermissions để cập nhật quyền
    //     // }
    
    //     return redirect()->route('nhanvien')->with('success', 'Thêm nhân viên mới thành công.');
    // }

    public function createNhanVien(Request $request)
    {
        // dd($request->all()); // Kiểm tra dữ liệu đầu vào
    
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ten_nhan_vien' => 'required|string|max:255',
            'ma_nhan_vien' => 'required|string|max:255',
            'bo_phan' => 'required|string|max:255',
            'chuc_danh' => 'required|string|max:255',
            'bac_tho' => 'required|string|max:255',
            'bac_AT' => 'required|string|max:255',
            'permissions' => 'array'
        ]);
    
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Tạo thông tin nhân viên
        NhanVien::create([
            'ten_nhan_vien' => $request->ten_nhan_vien,
            'ma_nhan_vien' => $request->ma_nhan_vien,
            'bo_phan' => $request->bo_phan,
            'chuc_danh' => $request->chuc_danh,
            'bac_tho' => $request->bac_tho,
            'bac_AT' => $request->bac_AT,
            'id_user' => $user->id,
            'id_permission' => $request->permissions ? $request->permissions[0] : null,
        ]);
    
        return redirect()->route('nhanvien')->with('success', 'Thêm nhân viên mới thành công.');
    }
    

    
    public function showFormEditNhanVien($id)
    {
    //     $nhanVien = NhanVien::findOrFail($id);
    // $permissions = Permission::all(); // Lấy tất cả các quyền để hiển thị
    // Tìm nhân viên và người dùng
    $nhanVien = NhanVien::findOrFail($id);
    $user = User::findOrFail($nhanVien->id_user);

    // Lấy danh sách các quyền từ cơ sở dữ liệu
    $permissions = Permission::all();

    // Trả về view với dữ liệu
 
    return view('pole_inspection.editNhanVien', [
        'nhanVien' => $nhanVien,
        'permissions' => $permissions,
    ]);
    // return view('pole_inspection.editNhanVien', compact('nhanVien', 'permissions'));

    

   
    }

    public function updateNhanVien(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        //     'password' => 'nullable|string|min:8|confirmed',
        //     'ten_nhan_vien' => 'required|string|max:255',
        //     'ma_nhan_vien' => 'required|string|max:255',
        //     'bo_phan' => 'required|string|max:255',
        //     'chuc_danh' => 'required|string|max:255',
        //     'bac_tho' => 'required|string|max:255',
        //     'bac_AT' => 'required|string|max:255',
        //     'id_permission' => 'nullable|exists:permissions,id'
        // ]);
    

        // Cập nhật thông tin người dùng
        $nhanVien = NhanVien::findOrFail($id);
        $user = User::findOrFail($nhanVien->id_user);
    
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
        ]);
    
        // Cập nhật thông tin nhân viên
        $nhanVien->update([
            'ten_nhan_vien' => $request->input('ten_nhan_vien'),
            'ma_nhan_vien' => $request->input('ma_nhan_vien'),
            'bo_phan' => $request->input('bo_phan'),
            'chuc_danh' => $request->input('chuc_danh'),
            'bac_tho' => $request->input('bac_tho'),
            'bac_AT' => $request->input('bac_AT'),
            'id_permission' => $request->input('id_permission')
        ]);
    
        return redirect()->route('nhanvien')->with('success', 'Nhân viên đã được cập nhật thành công!');
    }
    
    
    
    
    public function deleteNhanVien ($id)
{   
    // Tìm và xóa nhân viên
    $nhanVien = NhanVien::findOrFail($id);


    $user = User::find($nhanVien->id_user);
    if ($user) {
        $user->delete();
    }

    // Xóa nhân viên
    $nhanVien->delete();

    return redirect()->route('nhanvien')->with('success', 'Nhân viên đã được xóa.');
}
public function showCreateNhom()
{
    // Lấy danh sách nhân viên từ bảng nhanvien
    $nhanViens = NhanVien::all();
    
    return view('pole_inspection.addNhom', compact('nhanViens'));
}
    public function createNhom(Request $request)
    {
        $validated = $request->validate([
            'ten_nhom' => 'required|string|max:255',
            'thu_tu_nhom' => 'nullable|integer',
          
            'id_nhan_vien' => 'required|exists:nhanvien,id', // Kiểm tra khóa ngoại
        ]);

        Nhom::create($validated);

        return redirect()->route('nhom')->with('success', 'Nhóm đã được tạo thành công!');
    }

}