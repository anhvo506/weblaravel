<?php

namespace App\Http\Controllers;

use App\Models\Nhom;
use Illuminate\Http\Request;
use App\Models\Tuyen;
use App\Models\TramBienAp;
use App\Models\DuongDayTrungThe;
use App\Models\KiemTraTBA;

class TramController extends Controller
{
    public function showTram(Request $request)
{
    $phatTuyenId = $request->get('phat_tuyen_id');
    $duongDayId = $request->get('duong_day_id');

    // Lấy tất cả các phát tuyến để hiển thị trong select box
    $phatTuyens = Tuyen::all();

    // Lấy tất cả các đường dây để hiển thị trong select box
    // Kiểm tra xem có phải $duongDays là một tập hợp ID hoặc các đối tượng
    $duongDays = DuongDayTrungThe::all();

    // Xây dựng query để lọc trạm biến áp
    $query = TramBienAp::query();

    if ($phatTuyenId) {
        // Nếu có phát tuyến được chọn, lọc đường dây theo phát tuyến
        $duongDays = DuongDayTrungThe::where('tuyen_id', $phatTuyenId)->get();
        $query->whereIn('id_ddtt', $duongDays->pluck('id')); // Lấy ID của các đối tượng
    }

    if ($duongDayId) {
        // Nếu có đường dây được chọn, lọc trạm biến áp theo đường dây
        $query->where('id_ddtt', $duongDayId);
    }


// Lấy danh sách trạm biến áp với nhóm liên quan
$tramBienAps = $query->with('group')->get(); // Tải nhóm cùng với trạm biến áp
    // Truyền dữ liệu tới view
    return view('indexTram', compact('phatTuyens', 'duongDays', 'tramBienAps', 'phatTuyenId', 'duongDayId'));
}

// public function showCreateTram(Request $request)
// {
//     // $tuyens = Tuyen::all();
//     // $duongDays = [];

//     // if ($request->has('tuyen_id')) {
//     //     $tuyenId = $request->input('tuyen_id');
//     //     $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyenId)->get();
//     // }

//     // return view('pole_inspection.addTram', [
//     //     'tuyens' => $tuyens,
//     //     'duongDays' => $duongDays,
//     //     'selectedTuyenId' => $request->input('tuyen_id'),
//     //     'selectedDuongDayId' => $request->input('duong_day_id')
//     // ]);
//     $tuyens = Tuyen::all();
//     $duongDays = [];
//     $selectedTuyenId = $request->input('tuyen_id', '');
//     $selectedDuongDayId = $request->input('duong_day_id', '');

//     if ($selectedTuyenId) {
//         $duongDays = DuongDayTrungThe::where('tuyen_id', $selectedTuyenId)->get();
//     }

//     return view('pole_inspection.addTram', [
//         'tuyens' => $tuyens,
//         'duongDays' => $duongDays,
//         'selectedTuyenId' => $selectedTuyenId,
//         'selectedDuongDayId' => $selectedDuongDayId,
//     ]);
// }
// public function showCreateTram(Request $request)
// {
//     $tuyens = Tuyen::all();
//     $duongDays = [];
//     $selectedTuyenId = $request->input('tuyen_id', null); // Không có mặc định là ''

//     if ($selectedTuyenId) {
//         $duongDays = DuongDayTrungThe::where('tuyen_id', $selectedTuyenId)->get();
//     }

//     return view('pole_inspection.addTram', [
//         'tuyens' => $tuyens,
//         'duongDays' => $duongDays,
//         'selectedTuyenId' => $selectedTuyenId,
//         'selectedDuongDayId' => $request->input('duong_day_id'),
//     ]);
// }

// // Xử lý thêm trạm biến áp
// public function createTram(Request $request)
// {
//     // $request->validate([
//     //     'ten_tram' => 'required|string|max:255',
//     //     'dung_luong' => 'required|numeric',
//     //     'tuyen_id' => 'required|exists:tuyens,id',
//     //     'duong_day_id' => 'required|exists:duong_day_trung_thes,id',
//     // ]);

//     // TramBienAp::create([
//     //     'ten_tram' => $request->input('ten_tram'),
//     //     'dung_luong' => $request->input('dung_luong'),
//     //     'id_ddtt' => $request->input('duong_day_id'),
//     //     'tuyen_id' => $request->input('tuyen_id'), // Nếu có trường tuyen_id trong TramBienAp
//     // ]);
//     // $request->validate([
//     //     'ten_tram' => 'required|string|max:255',
//     //     'dung_luong' => 'required|numeric',
//     //     'tuyen_id' => 'required|exists:tuyens,id',
//     //     'duong_day_id' => 'required|exists:duong_day_trung_thes,id',
//     // ]);

//     // Lưu trạm mới
//     TramBienAp::create([
//         'ten_tram' => $request->input('ten_tram'),
//         'dung_luong' => $request->input('dung_luong'),
//         'tuyen_id' => $request->input('tuyen_id'),
//         'duong_day_id' => $request->input('duong_day_id'),
//     ]);

//     return redirect()->route('tram')->with('success', 'Trạm biến áp đã được thêm thành công.');
// }




// Hiển thị trang tạo trạm
public function showCreateTram(Request $request)
{
    $tuyens = Tuyen::all();
    $duongDays = [];
    $selectedTuyenId = $request->input('tuyen_id', '');
    $selectedDuongDayId = $request->input('duong_day_id', '');

    if ($selectedTuyenId) {
        $duongDays = DuongDayTrungThe::where('tuyen_id', $selectedTuyenId)->get();
    }

    return view('pole_inspection.addTram', [
        'tuyens' => $tuyens,
        'duongDays' => $duongDays,
        'selectedTuyenId' => $selectedTuyenId,
        'selectedDuongDayId' => $selectedDuongDayId,
    ]);
}

// Xử lý thêm trạm biến áp
    public function createTram(Request $request)
    {
        // Xác thực dữ liệu từ form
        $request->validate([
            'ten_tram' => 'required|string|max:255',
            'dung_luong' => 'required|numeric',
            'tuyen_id' => 'required|exists:tuyens,id',
            'duong_day_id' => 'required|exists:duong_day_trung_thes,id',
        ]);

        // Tạo mới trạm biến áp
        $tramBienAp = TramBienAp::create([
            'ten_tram' => $request->input('ten_tram'),
            'dung_luong' => $request->input('dung_luong'),
            'tuyen_id' => $request->input('tuyen_id'),
            'id_ddtt' => $request->input('duong_day_id'),
        ]);

        // Tạo bản ghi kiểm tra TBA liên quan
        $kiemTraTBA = KiemTraTBA::create([
            'tram_bien_ap_id' => $tramBienAp->id,
            'gio_kiem_tra' => null, // Giá trị mặc định hoặc để trống nếu không cần
            'hien_tuong_bat_thuong' => null, // Giá trị mặc định hoặc để trống nếu không cần
            'ton_tai_da_xu_ly' => null, // Giá trị mặc định hoặc để trống nếu không cần
            'bien_phap_de_nghi' => null, // Giá trị mặc định hoặc để trống nếu không cần
        ]);

        // Cập nhật ID kiểm tra vào trạm biến áp
        $tramBienAp->update(['id_kiem_tra' => $kiemTraTBA->id]);

        return redirect()->route('tram')->with('success', 'Trạm biến áp và kiểm tra đã được thêm thành công.');
    }
        public function showFormEditTram($id)
        {
            $tramBienAp = TramBienAp::findOrFail($id);
            return view('pole_inspection.editTram', compact('tramBienAp'));
        }

        public function updateTram(Request $request, $id)
    {
        $request->validate([
            'ten_tram' => 'required|string|max:255',
            'dung_luong' => 'required|numeric',
            // Thêm các trường khác nếu cần
        ]);

        $tramBienAp = TramBienAp::findOrFail($id);
        $tramBienAp->update([
            'ten_tram' => $request->input('ten_tram'),
            'dung_luong' => $request->input('dung_luong'),
            // Cập nhật các trường khác nếu cần
        ]);

        return redirect()->route('tram')->with('success', 'Trạm biến áp đã được cập nhật thành công.');
    }
    public function deleteTram($id)
    {
        $tramBienAp = TramBienAp::findOrFail($id);

        // Lấy id_kiem_tra của trạm biến áp
        $idKiemTra = $tramBienAp->id_kiem_tra;

        // Xóa các kiểm tra liên quan
        KiemTraTBA::where('id', $idKiemTra)->delete();

        // Xóa trạm biến áp
        $tramBienAp->delete();

        return redirect()->route('tram')->with('success', 'Trạm biến áp và các thông tin kiểm tra liên quan đã được xóa thành công.');
    }
    public function assignGroup($id)
    {
        $tramBienAp = TramBienAp::findOrFail($id);
        $groups = Nhom::all(); // Lấy tất cả các nhóm



        return view('pole_inspection.assignGroup', compact('tramBienAp', 'groups'));
    }
   
    public function saveAssignGroup(Request $request, $id)
    {
        $tramBienAp = TramBienAp::findOrFail($id);
        $tramBienAp->id_nhom = $request->input('group_id');
        $tramBienAp->save();

        return redirect()->route('tram')->with('success', 'Nhóm đã được phân công thành công.');
    }
}