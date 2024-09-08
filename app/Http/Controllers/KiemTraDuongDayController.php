<?php

namespace App\Http\Controllers;

use App\Models\KiemTraDuongDay;
use App\Models\KiemTraTBA;
use Illuminate\Http\Request;
use App\Models\Tuyen;
use App\Models\TramBienAp;
use App\Models\DuongDayTrungThe;


class KiemTraDuongDayController extends Controller
{

    public function showKiemTraDuongDay(Request $request)
{
    $tuyens = Tuyen::all();
    $duongDays = collect();
    $kiemTraDDTT = collect();

    $tuyenId = $request->input('tuyen_id');
    $duongDayId = $request->input('duong_day_id');

    if ($tuyenId) {
        $duongDays = DuongDayTrungThe::where('tuyen_id', $tuyenId)->get();
    }

    if ($duongDayId) {
        // Lấy id_kiem_tra từ bảng duong_day_trung_thes
        $duongDay = DuongDayTrungThe::find($duongDayId);
        if ($duongDay) {
            $kiemTraDDTT = KiemTraDuongDay::where('id', $duongDay->id_kiem_tra)->get();
        }
    }

    return view('indexKiemTraDuongDay', [
        'tuyens' => $tuyens,
        'duongDays' => $duongDays,
        'kiemTraDDTT' => $kiemTraDDTT,
        'tuyenId' => $tuyenId,
        'duongDayId' => $duongDayId,
    ]);
}
    



}