<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuyen;
use App\Models\TramBienAp;
use App\Models\DuongDayTrungThe;
use App\Models\NhanVien;
use App\Models\KiemTraTBA;
use App\Models\Nhom;
use App\Models\DonVi;
use App\Models\User;
use App\Models\Doi;

class DonViController extends Controller
{
    public function showDonVi()
    {
        $donVis = DonVi::all();
        return view('indexDonVi', compact('donVis'));
    }
    public function showCreateDonVi()
    {
        $donVis = DonVi::all();
        return view('pole_inspection.addDonVi', compact('donVis'));
    }
    public function createDonVi(Request $request)
    {
        $request->validate([
            'ma_don_vi' => 'required|string|max:255',
            'ma_vung' => 'required|string|max:255',
            'ten_don_vi' => 'required|string|max:255',
            'ten_tat' => 'required|string|max:255',
        ]);

        DonVi::create([
            'ma_don_vi' => $request->ma_don_vi,
            'ma_vung' => $request->ma_vung,
            'ten_don_vi' => $request->ten_don_vi,
            'ten_tat' => $request->ten_tat,
        ]);

        return redirect()->route('donvi')->with('success', 'Đơn vị đã được tạo thành công!');
    }
    public function showFormEditDonVi()
    {
        $donVis = DonVi::all();
        return view('pole_inspection.editDonVi', compact('donVis'));
    }
    public function updateDv(Request $request, $id)
    {
        $request->validate([
            'ma_don_vi' => 'required',
            'ma_vung' => 'required',
            'ten_don_vi' => 'required',
            'ten_tat' => 'required',
        ]);

        $donVi = DonVi::findOrFail($id);
        $donVi->update($request->all());

        return redirect()->route('donvi')->with('success', 'Cập nhật thành công!');
    }

    public function deleteDonVi($id)
    {
        $donVi = DonVi::findOrFail($id);

        // Kiểm tra nếu đơn vị có tuyến
        if (Tuyen::where('id_don_vi', $id)->exists()) {
            return redirect()->route('donvi')->with('error', 'Không thể xóa đơn vị vì có tuyến liên quan.');
        }

        $donVi->delete();

        return redirect()->route('donvi')->with('success', 'Đơn vị đã được xóa thành công.');
    }
}