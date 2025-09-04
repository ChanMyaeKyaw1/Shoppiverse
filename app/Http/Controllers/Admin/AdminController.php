<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use function Laravel\Prompts\select;

use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // direct admin dashboard
    public function dashboard() {
        $totalSaleAmt = PaymentHistory::sum('total_amt');
        $orderCount = Order::whereIn('status', [0,1])->count('id');
        $registerUser = User::where('role', 'user')->count('id');
        $pendingCount = Order::where('status', [0])->count('id');

        return view('admin.dashboard.main', compact('totalSaleAmt', 'orderCount', 'registerUser', 'pendingCount'));
    }

    // create new admin page
    public function createAdminPage() {
        return view('admin.account.newAdmin');
    }

    // create new admin accounts
    public function createAdmin(Request $request) {
        $this->checkAccountValidation($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Alert::success('Success Title', 'New Admin Account Created Successfully');
        return back();
    }

    // create admin list
    public function adminList() {
        $admin = User::select('id', 'profile', 'name', 'nickname', 'email', 'address', 'phone', 'role', 'created_at', 'provider')
                ->whereIn('role', ['admin', 'superadmin'])
            ->when(request('searchKey'), function($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'role'], 'like', '%'.request('searchKey').'%');
            })
            ->paginate(4);

        return view('admin.account.adminList', compact('admin'));

    }

    // delete admin account from list
    public function adminDelete($id) {
        User::where('id', $id)->delete();
        return back();
    }

    // create user list
    public function userList() {
        $user = User::select('id', 'profile', 'name', 'nickname', 'email', 'address', 'phone', 'role', 'created_at', 'provider')
                ->whereIn('role', ['user'])
            ->when(request('searchKey'), function($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'role'], 'like', '%'.request('searchKey').'%');
            })
            ->paginate(4);

        return view('admin.account.userList', compact('user'));
    }

    // delete user account from list
    public function userDelete($id) {
        User::where('id', $id)->delete();
        return back();
    }

    // check account validation
    private function checkAccountValidation($request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:password',
        ]);
    }

}
