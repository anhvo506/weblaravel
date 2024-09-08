<?php

namespace App\Http\Controllers;

use App\Models\DuongDayTrungThe;
use App\Models\Tuyen;
use Illuminate\Http\Request;

class DuongDayController extends Controller
{
    public function showDuongDay(Request $request)
    {
        $phatTuyens = Tuyen::all();

        $selectedPhatTuyenId = $request->input('phat_tuyen_id', $phatTuyens->first()->id);

        $duongDayTrungThes = DuongDayTrungThe::where('tuyen_id', $selectedPhatTuyenId)->get();

        return view('indexDuongDay', compact('phatTuyens', 'duongDayTrungThes', 'selectedPhatTuyenId'));
    }
    
    public function showCreateDuongDay()
    {
        $phatTuyens = Tuyen::all();
        return view('pole_inspection.addDuongDay', compact('phatTuyens'));
    }

    public function createDuongDay(Request $request)
    {
        $request->validate([
            'ten_duong_day' => 'required|string|max:255',
            'tu_vi_tri_tru' => 'required|string|max:255',
            'den_vi_tri_tru' => 'required|string|max:255',
            'chieu_dai' => 'required|string|max:255',
            'phat_tuyen_id' => 'required|exists:tuyens,id', 
        ]);

        DuongDayTrungThe::create([
            'ten_duong_day' => $request->input('ten_duong_day'),
            'tu_vi_tri_tru' => $request->input('tu_vi_tri_tru'),
            'den_vi_tri_tru' => $request->input('den_vi_tri_tru'),
            'chieu_dai' => $request->input('chieu_dai'),
            'tuyen_id' => $request->input('phat_tuyen_id'), 
        ]);

        return redirect()->route('duongday')->with('success', 'Tạo mới đường dây thành công.');
    }
    public function showFormEditDuongDay($id, $phat_tuyen_id)
{
    $duongDayTrungThe = DuongDayTrungThe::findOrFail($id);
    $phatTuyen = Tuyen::findOrFail($phat_tuyen_id);

    return view('pole_inspection.editDuongDay', compact('duongDayTrungThe', 'phatTuyen'));
}
    public function updateDuongDay(Request $request, $id)
{
    $request->validate([
        'ten_duong_day' => 'required|string|max:255',
        'tu_vi_tri_tru' => 'required|string|max:255',
        'den_vi_tri_tru' => 'required|string|max:255',
        'chieu_dai' => 'required|string|max:255',
     
    ]);

    $duongDayTrungThe = DuongDayTrungThe::findOrFail($id);
    $duongDayTrungThe->update([
        'ten_duong_day' => $request->input('ten_duong_day'),
        'tu_vi_tri_tru' => $request->input('tu_vi_tri_tru'),
        'den_vi_tri_tru' => $request->input('den_vi_tri_tru'),
        'chieu_dai' => $request->input('chieu_dai'),
       
    ]);

    return redirect()->route('duongday')->with('success', 'Cập nhật đường dây thành công.');
}
    public function deleteDuongDay($id)
    {
        $duongDayTrungThe = DuongDayTrungThe::findOrFail($id);
        $duongDayTrungThe->delete();

        return redirect()->route('duongday')->with('success', 'Xóa đường dây thành công.');
    }
}
