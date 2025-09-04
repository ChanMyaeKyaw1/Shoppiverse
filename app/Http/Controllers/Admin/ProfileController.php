<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // change password page
    public function changePasswordPage() {
        return view('admin.profile.changePassword');
    }

    // edit profile
    public function editProfile() {
        return view('admin.profile.edit');
    }

    // update profile
    public function updateProfile(Request $request) {
        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if($request->hasFile('image')) {

            // if choose image
            if(Auth::user()->profile != null) {
                if( file_exists( public_path().'/profile/' .Auth::user()->profile ) ) {
                        unlink( public_path().'/profile/' .Auth::user()->profile ); // delete the old image
                }
            }
            // if both choose image and already has image
            $fileName = uniqid(). $request->file("image")->getClientOriginalName();
                $request->file("image")->move( public_path(). "/profile/", $fileName );
                $data['profile'] = $fileName;

        } else {
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id', Auth::user()->id)->update($data);

        Alert::success('Success Title', 'Profile Updated Successfully');
            return back();
        }

    // change password
    public function changePassword(Request $request) {
        $userRegisterPassword = Auth::user()->password; // hash value

        // syntax must be Hash::check( hashvalue, plain text value)
        if( Hash::check( $request->oldPassword, $userRegisterPassword ) ) {
            $this->checkPasswordValidation($request);

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword),
            ]);

            Alert::success('Success Title', 'Password Changed Successfully');
            return back();

            // Auth::logout();
            // // to clear login data cache for security
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();

            // return redirect('/'); // go to login page

        } else {
            Alert::error('Process Fail...', 'Old password does not match our records. Try Again...');
            return back();
        }
    }

    // password validation check
    private function checkPasswordValidation($request) {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ]);
    }

    // update validation check
    private function checkProfileValidation($request) {
        $request->validate([
                'name' => 'required|min:2|max:30',
                'email' => 'required|unique:users,email,' .Auth::user()->id,
                'phone' => 'required|max:20',
                'address' => 'max:200',
                'image' => 'file|mimes:png,jpg,jpeg,webp,svg,gif'
        ]);
    }

    // get profile data
    private function getProfileData($request) {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
}
