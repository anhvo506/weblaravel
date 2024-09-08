<?php

namespace App\Http\Controllers;

use App\Models\KiemTraTBA;
use Illuminate\Http\Request;
use App\Models\Tuyen;
use App\Models\TramBienAp;
use App\Models\DuongDayTrungThe;


class KiemTraTramController extends Controller
{

    public function showKiemTraTBA(Request $request)
{
    $tuyens = Tuyen::all();
    $duongDays = collect();
    $tramBienAps = collect();
    $kiemTraTBA = null;
    
    $tuyenId = $request->get('tuyen_id');
    $duongDayId = $request->get('duong_day_id');
    $tramBienApId = $request->get('tram_bien_ap_id');

    if ($tuyenId) {
        $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyenId)->get();
    }

    if ($duongDayId) {
        $tramBienAps = TramBienAp::where('id_ddtt', $duongDayId)->get();
    }

    if ($tramBienApId) {
        // Tìm trạm biến áp theo ID
        $tramBienAp = TramBienAp::find($tramBienApId);

        if ($tramBienAp && $tramBienAp->id_kiem_tra) {
            // Tìm kiểm tra TBA theo ID kiểm tra
            $kiemTraTBA = KiemTraTBA::find($tramBienAp->id_kiem_tra);
        }
    }

    return view('indexKiemTraTram', compact('tuyens', 'duongDays', 'tramBienAps', 'kiemTraTBA', 'tuyenId', 'duongDayId', 'tramBienApId'));
}

    // public function showCreateKiemTraTBA(Request $request)
    // {
    //     // Lấy danh sách trạm biến áp để lựa chọn
    //     $tramBienAps = TramBienAp::all();

    //     return view('pole_inspection.addKiemTraTBA', compact('tramBienAps'));
    // }
    public function showCreateKiemTraTBA(Request $request)
{
    $tuyens = Tuyen::all();
    $duongDays = collect();
    $tramBienAps = collect();

    $tuyenId = $request->get('tuyen_id');
    $duongDayId = $request->get('duong_day_id');
    $tramBienApId = $request->get('tram_bien_ap_id');

    if ($tuyenId) {
        $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyenId)->get();
    }

    if ($duongDayId) {
        $tramBienAps = TramBienAp::where('id_ddtt', $duongDayId)->get();
    }

    return view('pole_inspection.addKiemTraTBA', compact('tuyens', 'duongDays', 'tramBienAps', 'tuyenId', 'duongDayId', 'tramBienApId', 'request'));
}
//     public function showCreateKiemTraTBA(Request $request)
// {
//     $tuyens = Tuyen::all();
//     $duongDays = collect();
//     $tramBienAps = collect();

//     $tuyenId = $request->get('tuyen_id');
//     $duongDayId = $request->get('duong_day_id');

//     if ($tuyenId) {
//         $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyenId)->get();
//     }

//     if ($duongDayId) {
//         $tramBienAps = TramBienAp::where('id_ddtt', $duongDayId)->get();
//     }

//     return view('pole_inspection.addKiemTraTBA', compact('tuyens', 'duongDays', 'tramBienAps', 'tuyenId', 'duongDayId'));
// }
public function createKiemTraTBA(Request $request)
{
    // Xác thực dữ liệu từ form
    $request->validate([
        // 'tram_bien_ap_id' => 'required|exists:tram_bien_ap,id',
        'gio_kiem_tra' => 'required|date_format:Y-m-d\TH:i',
        'hien_tuong_bat_thuong' => 'nullable|string',
        'ton_tai_da_xu_ly' => 'nullable|string',
        'bien_phap_de_nghi' => 'nullable|string',
    ]);

    // Tìm trạm biến áp để lấy id_kiem_tra
    $tramBienAp = TramBienAp::find($request->tram_bien_ap_id);

    // Tạo mới kiểm tra TBA
    $kiemTraTBA = KiemTraTBA::create([
        // 'tram_bien_ap_id' => $tramBienAp->id, // Đặt id_tram_bien_ap nếu cần
        'gio_kiem_tra' => $request->gio_kiem_tra,
        'hien_tuong_bat_thuong' => $request->hien_tuong_bat_thuong,
        'ton_tai_da_xu_ly' => $request->ton_tai_da_xu_ly,
        'bien_phap_de_nghi' => $request->bien_phap_de_nghi,
    ]);

    // Cập nhật id_kiem_tra vào trạm biến áp
    $tramBienAp->update(['id_kiem_tra' => $kiemTraTBA->id]);

    return redirect()->route('kiemtratram', ['tram_bien_ap_id' => $tramBienAp->id])
                     ->with('success', 'Thông tin kiểm tra đã được thêm mới.');
}
public function showFormEditKiemTraTBA($id)
    {
        $kiemTraTBA = KiemTraTBA::findOrFail($id);
        return view('pole_inspection.editKiemTraTBA', compact('kiemTraTBA'));
    }

public function updateKiemTraTBA(Request $request, $id)
{
    $request->validate([
        'gio_kiem_tra' => 'required|date_format:Y-m-d\TH:i',
        'hien_tuong_bat_thuong' => 'nullable|string',
        'ton_tai_da_xu_ly' => 'nullable|string',
        'bien_phap_de_nghi' => 'nullable|string',
    ]);

    $kiemTraTBA = KiemTraTBA::findOrFail($id);
    $kiemTraTBA->update($request->all());

    return redirect()->route('kiemtratram', ['tram_bien_ap_id' => $kiemTraTBA->tram_bien_ap_id])
                     ->with('success', 'Thông tin kiểm tra đã được cập nhật.');
}
public function deleteKiemTraTBA($id)
{
    // Tìm bản ghi KiemTraTBA theo ID và xóa nó
    $kiemTraTBA = KiemTraTBA::findOrFail($id);
    $tramBienApId = $kiemTraTBA->tram_bien_ap_id; // Giữ lại ID của trạm biến áp để điều hướng lại sau khi xóa
    $kiemTraTBA->delete(); // Xóa bản ghi KiemTraTBA

    // Chuyển hướng lại trang danh sách kiểm tra trạm biến áp với thông báo thành công
    return redirect()->route('kiemtratram', ['tram_bien_ap_id' => $tramBienApId])
                     ->with('success', 'Thông tin kiểm tra đã được xóa.');
}

}