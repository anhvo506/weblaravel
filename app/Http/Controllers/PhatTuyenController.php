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

class PhatTuyenController extends Controller
{
    // public function index()
    // {

    //     $tuyens = Tuyen::with(['duongDayTrungThes', 'tramBienAps'])->get();


    //     return view('index', ['tuyens' => $tuyens]);
    // }

    
    public function showPhatTuyen()
    {
        // Lấy tất cả các tuyến và kèm theo đơn vị
        $phatTuyens = Tuyen::with('donVi')->get();
        return view('indexPhatTuyen', compact('phatTuyens'));
    }
    public function getDuongDaysByTuyen($tuyen_id)
    {
        $tuyen = Tuyen::findOrFail($tuyen_id);
        $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyen_id)->get();
        return view('duongdaytheotuyen', compact('tuyen', 'duongDays'));
    
        
    }
    public function showCreateTuyen()
    {
        $donVis = DonVi::all();
        return view('pole_inspection.addTuyen', compact('donVis'));
    }
    public function createTuyen(Request $request)
{
    // Validate input data
    $request->validate([
        'ten_tuyen' => 'required|string|max:255',
        'don_vi_id' => 'required|exists:don_vis,id',
    ]);

    // Check if a Tuyen with the same name and don_vi_id already exists
    $existingTuyen = Tuyen::where('ten_tuyen', $request->ten_tuyen)
                          ->where('id_don_vi', $request->input('don_vi_id'))
                          ->first();

    if ($existingTuyen) {
        // If it exists, redirect back with an error message
        return redirect()->route('phattuyen')->with('error', 'Tuyến với tên và đơn vị này đã tồn tại.');
    }

    // If it doesn't exist, create the new Tuyen
    Tuyen::create([
        'ten_tuyen' => $request->ten_tuyen,
        'id_don_vi' => $request->input('don_vi_id'),
    ]);

    // Redirect back with a success message
    return redirect()->route('phattuyen')->with('success', 'Tuyến mới đã được thêm thành công!');
}
    public function deleteTuyen($id)
    {
        // Tìm tuyến theo ID và xóa nó
        $tuyen = Tuyen::findOrFail($id);
        $tuyen->delete();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('phattuyen')->with('success', 'Tuyến đã được xóa thành công!');
    }

    public function showFormEditTuyen($id)
    {
        $tuyen = Tuyen::findOrFail($id);
        $donVis = DonVi::all(); 
        return view('pole_inspection.editTuyen', compact('tuyen', 'donVis'));
    }

  
    public function updateTuyen(Request $request, $id)
    {
        $request->validate([
            'ten_tuyen' => 'required|string|max:255',
            'don_vi_id' => 'required|exists:don_vis,id',
        ]);

        $tuyen = Tuyen::findOrFail($id);
        $tuyen->update([
            'ten_tuyen' => $request->ten_tuyen,
            'id_don_vi' => $request->don_vi_id,
        ]);

        return redirect()->route('phattuyen')->with('success', 'Cập nhật tuyến thành công!');
    }

}