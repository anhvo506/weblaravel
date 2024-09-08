<?php

use App\Http\Controllers\KiemTraTramController;
use App\Http\Controllers\PoleInspectionController;
use App\Http\Controllers\DoiController;
use App\Http\Controllers\PhatTuyenController;
use App\Http\Controllers\DonViController;
use App\Http\Controllers\DuongDayController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\TramController;
use App\Http\Controllers\NhomController;
use App\Http\Controllers\KiemTraTBAController;
use App\Http\Controllers\KiemTraDuongDayController;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect về trang đăng nhập hoặc trang khác
})->name('logout');

// Admin routes with middleware
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', function () {
        return view('index');
    })->name('admin');
    Route::get('/admin', [PhatTuyenController::class, 'showPhatTuyen'])->name('phattuyen'); 
    
    
    //TUYEN
    // Route::middleware(['auth', 'permission:admin'])->group(function () {
    Route::get('/phattuyen', [PhatTuyenController::class, 'showPhatTuyen'])->name('phattuyen');
    // });
    Route::middleware(['auth', 'permission:admin'])->group(function () {
    Route::get('/tuyen/create', [PhatTuyenController::class, 'showCreateTuyen'])->name('showCreateTuyen');
    Route::post('/tuyen/create', [PhatTuyenController::class, 'createTuyen'])->name('createTuyen');
    Route::get('/tuyen/edit/{id}', [PhatTuyenController::class, 'showFormEditTuyen'])->name('editTuyen');
    Route::post('/tuyen/{id}/edit', [PhatTuyenController::class, 'updateTuyen'])->name('updateTuyen');
    Route::delete('/tuyen/{id}', [PhatTuyenController::class, 'deleteTuyen'])->name('deleteTuyen');
});

    //DOI
    Route::get('/doi', [DoiController::class, 'showDoi'])->name('doi');
    Route::get('/doi/create', [DoiController::class, 'showCreateDoi'])->name('showCreateForm');
    Route::post('/doi/create', [DoiController::class, 'createDoi'])->name('createDoi');
    Route::get('/doi/{id}/edit', [DoiController::class, 'showFormEditDoi'])->name('showEditDoi');
    Route::post('/doi/{id}/edit', [DoiController::class, 'updateDoi'])->name('updateDoi');
    Route::delete('/doi/{id}', [DoiController::class, 'deleteDoi'])->name('deleteDoi');

    //DONVI
    Route::get('/donvi', [DonViController::class, 'showDonVi'])->name('donvi');
    Route::get('/donvi/{id}/edit', [DonViController::class, 'showFormEditDonVi'])->name('showFormEditDonVi');
    Route::post('/donvi/{id}/edit', [DonViController::class, 'updateDv'])->name('updateDonVi');
    Route::delete('/donvi/{id}', [DonViController::class, 'deleteDonVi'])->name('deleteDonVi');
    Route::get('/donvi/create', [DonViController::class, 'showCreateDonVi'])->name('showCreateDonVi');
    Route::post('/donvi/create', [DonViController::class, 'createDonVi'])->name('createDonVi');


    //NHOM
    Route::get('/nhom', [NhomController::class, 'showNhom'])->name('nhom');
    Route::get('/nhom/create', [NhomController::class, 'showCreateNhom'])->name('showCreateNhom');
    Route::post('/nhom/create', [NhomController::class, 'createNhom'])->name('createNhom');
    Route::delete('/nhom/{id}', [NhomController::class, 'deleteNhom'])->name('deleteNhom');
    Route::get('/nhom/{id}/edit', [NhomController::class, 'showFormEditNhom'])->name('showFormEditNhom');
    Route::post('/nhom/{id}/edit', [NhomController::class, 'updateNhom'])->name('updateNhom');



    //QUYEN
    
    // Route::get('/quyen', [QuyenController::class, 'showQuyen'])->name('quyen');

    // showDuongDayTheoTuyen
    Route::get('/tuyen/{id}/duongday', [PhatTuyenController::class, 'getDuongDaysByTuyen'])->name('showDuongDayTheoTuyen');



    
    
    
    //TRAMBIENAP
    Route::get('/tram', [TramController::class, 'showTram'])->name('tram');
    
    Route::get('/tram/{id}/edit', [TramController::class, 'showFormEditTram'])->name('showFormEditTram');
    Route::put('/tram/{id}/edit', [TramController::class, 'updateTram'])->name('updateTram');
    Route::delete('/tram/{id}', [TramController::class, 'deleteTram'])->name('deleteTram');
    Route::get('/tram/create', [TramController::class, 'showCreateTram'])->name('showCreateTram');
    Route::post('/tram/create', [TramController::class, 'createTram'])->name('createTram');
    // Route phân công nhóm cho trạm biến áp
    Route::get('/assigngroup/{id}', [TramController::class, 'assignGroup'])->name('assignGroup');
    Route::post('/save-assign-group/{id}', [TramController::class, 'saveAssignGroup'])->name('saveAssignGroup');



    //DUONGDAY
    Route::get('/duongday', [DuongDayController::class, 'showDuongDay'])->name('duongday');
    Route::get('/duongday/create', [DuongDayController::class, 'showCreateDuongDay'])->name('showCreateDuongDay');
    Route::post('/duongday/create', [DuongDayController::class, 'createDuongDay'])->name('createDuongDay');
    Route::get('/duongday/edit/{id}/{phat_tuyen_id}', [DuongDayController::class, 'showFormEditDuongDay'])->name('showFormEditDuongDay');
    Route::post('/duongday/{id}/edit', [DuongDayController::class, 'updateDuongDay'])->name('updateDuongDay');
    Route::delete('/duongday/{id}', [DuongDayController::class, 'deleteDuongDay'])->name('deleteDuongDay');

    Route::get('/tuyen/{id}/duongday', [PhatTuyenController::class, 'getDuongDaysByTuyen'])->name('showDuongDayTheoTuyen');


    // NHANVIEN
    Route::get('/nhanvien', [NhanVienController::class, 'showNhanVien'])->name('nhanvien');
    Route::get('/nhanvien/create', [NhanVienController::class, 'showCreateNhanVien'])->name('showCreateNhanVien');
    Route::post('/nhanvien/create', [NhanVienController::class, 'createNhanVien'])->name('createNhanVien');
    Route::get('/nhanvien/{id}/edit', [NhanVienController::class, 'showFormEditNhanVien'])->name('showFormEditNhanVien');
    Route::put('/nhanvien/{id}/edit', [NhanVienController::class, 'updateNhanVien'])->name('updateNhanVien');
    Route::delete('/nhanvien/{id}', [NhanVienController::class, 'deleteNhanVien'])->name('deleteNhanVien');

    //showTBATheoDuongDay
    Route::get('/duongday/{id}/tram', [PoleInspectionController::class, 'getTBAsByDuongDay'])->name('showTBATheoDuongDay');

    Route::get('/admin/form', [PoleInspectionController::class, 'showForm'])->name('admin.form');
    
    Route::get('/test', [PoleInspectionController::class, 'showFormTest'])->name('test');
    Route::post('/admin', [PoleInspectionController::class, 'submitForm'])->name('admin.submit');

    // KIEM TRA TBA
    Route::get('/kiemtratram', [KiemTraTramController::class, 'showKiemTraTBA'])->name('kiemtratram');
    Route::get('/kiemtratram/create', [KiemTraTramController::class, 'showCreateKiemTraTBA'])->name('showCreateKiemTraTBA');
    Route::post('/kiemtratram/create', [KiemTraTramController::class, 'createKiemTraTBA'])->name('createKiemTraTBA');
    Route::get('/kiemtratram/{id}/edit', [KiemTraTramController::class, 'showFormEditKiemTraTBA'])->name('showFormEditKiemTraTBA');
    Route::put('/kiemtratram/{id}/edit', [KiemTraTramController::class, 'updateKiemTraTBA'])->name('updateKiemTraTBA');
    Route::delete('/kiemtratram/{id}', [KiemTraTramController::class, 'deleteKiemTraTBA'])->name('deleteKiemTraTBA');


    //KIEM TRA DUONG DAY
    Route::get('/kiemtraduongday', [KiemTraDuongDayController::class, 'showKiemTraDuongDay'])->name('kiemtraduongday');
    




    // Route::get('/addTest', [PoleInspectionController::class, 'createTest'])->name('addTest');
    // Route::delete('/delete-pole/{id}', [PoleInspectionController::class, 'destroy'])->name('admin.destroy');
    // Route::get('/admin/{id}/edit', [PoleInspectionController::class, 'edit'])->name('admin.edit');
    // Route::put('/admin/{id}', [PoleInspectionController::class, 'update'])->name('admin.update');
    // Route::post('/assignments', [PoleInspectionController::class, 'assignment'])->name('assignments.assignment');
    // Route::post('/createTramBienAp', [PoleInspectionController::class, 'createTram'])->name('createTramBienAp.createTram');
    // Route::post('/createKiemTraTBA', [PoleInspectionController::class, 'createKiemTraTram'])->name('createKiemTraTBA.createKiemTraTram');
    
   
});



