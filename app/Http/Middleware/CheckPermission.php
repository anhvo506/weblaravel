<?php

namespace App\Http\Middleware;

use App\Models\NhanVien;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    // public function handle(Request $request, Closure $next, $permission)
    // {
    //     // Kiểm tra xem người dùng đã đăng nhập chưa
    //     if (!auth()->check()) {
    //         return redirect('admin');
    //     }

    //     $user = auth()->user();
        
    //     // Kiểm tra quyền của người dùng
    //     if (!$user->permissions()->where('name', $permission)->exists()) {
    //         return redirect('admin');
    //     }
        
    //     // Nếu quyền hợp lệ, tiếp tục xử lý yêu cầu
    //     return $next($request);
    // }
    //     public function handle(Request $request, Closure $next, $permission)
    // {
    //     // Kiểm tra xem người dùng đã đăng nhập chưa
    //     if (!auth()->check()) {
    //         return redirect('admin');
    //     }

    //     $user = auth()->user();
        
    //     // Kiểm tra quyền của người dùng
    //     if (!$user->hasPermission($permission)) {
    //         return redirect('admin');
    //     }
        
    //     // Nếu quyền hợp lệ, tiếp tục xử lý yêu cầu
    //     return $next($request);
    // }


    public function handle(Request $request, Closure $next, $requiredPermission)
{
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!auth()->check()) {
        return redirect('login')->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
    }

    $user = auth()->user();
    
    // Lấy thông tin nhân viên dựa trên user_id
    $nhanVien = NhanVien::where('id_user', $user->id)->first();
    
    if (!$nhanVien) {
        return redirect('admin')->with('error', 'Không tìm thấy nhân viên liên kết với tài khoản của bạn.');
    }

    // Kiểm tra quyền của nhân viên dựa trên permission_id
    $permission = Permission::find($nhanVien->id_permission);

    if (!$permission || $permission->name !== $requiredPermission) {
        return redirect('admin')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
    
    // Nếu quyền hợp lệ, tiếp tục xử lý yêu cầu
    return $next($request);
}

}
