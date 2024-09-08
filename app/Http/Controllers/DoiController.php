<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nhom;
use App\Models\Doi;

class DoiController extends Controller
{
    public function showDoi()
    {
        $dois = Doi::with('nhoms')->get();
        return view('indexDoi', compact('dois'));
    }
    public function showCreateDoi()
    {
        // Lấy tất cả các nhóm chưa được gán cho đội nào
        $nhoms = Nhom::whereNull('id_doi')->get();
        return view('pole_inspection.addDoi', compact('nhoms'));
    }

    public function createDoi(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ma_doi' => 'required|string|max:255|unique:dois,ma_doi',
            'ten_doi' => 'required|string|max:255',
            'nhom_ids' => 'array',
            'nhom_ids.*' => 'exists:nhoms,id',
        ]);

        // Tạo đội mới
        $doi = Doi::create([
            'ma_doi' => $request->input('ma_doi'),
            'ten_doi' => $request->input('ten_doi'),
        ]);

        // Cập nhật các nhóm liên quan
        $nhomIds = $request->input('nhom_ids', []);
        Nhom::whereIn('id', $nhomIds)->update(['id_doi' => $doi->id]);

        // Chuyển hướng hoặc trả về thông báo
        return redirect()->route('doi')->with('success', 'Thêm đội thành công.');
    }

    // public function showFormEditDoi($id)
    // {
    //     // Lấy thông tin đội cần chỉnh sửa
    //     $doi = Doi::findOrFail($id);

    //     // Lấy tất cả các nhóm chưa được gán cho đội nào
    //     $nhoms = Nhom::whereNull('id_doi')->get();

    //     // Truyền dữ liệu vào view
    //     return view('pole_inspection.editDoi', compact('doi', 'nhoms'));
    // }
//     public function showFormEditDoi($id)
// {
//     $doi = Doi::with('nhoms')->findOrFail($id);
//     $nhoms = Nhom::all();
//     return view('pole_inspection.editDoi', compact('doi', 'nhoms'));
// }
public function showFormEditDoi($id)
{
    // Lấy thông tin đội cần chỉnh sửa
    $doi = Doi::findOrFail($id);

    // Lấy tất cả các nhóm chưa được gán cho đội nào hoặc thuộc về đội hiện tại
    $nhoms = Nhom::where(function ($query) use ($id) {
        $query->whereNull('id_doi')
              ->orWhere('id_doi', $id);
    })->get();

    // Truyền dữ liệu vào view
    return view('pole_inspection.editDoi', compact('doi', 'nhoms'));
}

    public function updateDoi(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ma_doi' => 'required|string|max:255',
            'ten_doi' => 'required|string|max:255',
            'nhom_ids' => 'array', // mảng nhóm
            'nhom_ids.*' => 'exists:nhoms,id' // đảm bảo rằng mỗi id nhóm tồn tại trong bảng nhoms
        ]);

        // Lấy đội để cập nhật
        $doi = Doi::findOrFail($id);

        // Cập nhật thông tin đội
        $doi->update([
            'ma_doi' => $request->input('ma_doi'),
            'ten_doi' => $request->input('ten_doi'),
        ]);

        // Lấy tất cả các ID nhóm từ mảng nhom_ids
        $nhomIds = $request->input('nhom_ids', []);

        // Cập nhật các nhóm liên quan
        // Đặt id_doi của tất cả nhóm được chọn bằng id của đội hiện tại
        Nhom::whereIn('id', $nhomIds)->update(['id_doi' => $doi->id]);

        // Đặt id_doi của các nhóm không được chọn về null chỉ nếu chúng không thuộc đội nào khác
        Nhom::whereNotIn('id', $nhomIds)
            ->where('id_doi', $doi->id) // chỉ cập nhật những nhóm hiện tại thuộc đội này
            ->update(['id_doi' => null]);

        // Chuyển hướng hoặc trả về thông báo
        return redirect()->route('doi')->with('success', 'Cập nhật đội thành công.');
    }




}