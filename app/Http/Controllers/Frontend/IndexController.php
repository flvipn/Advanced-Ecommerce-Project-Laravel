<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class IndexController extends Controller
{
    public function index(){
        return view('frontend.index');
    }

    public function UserLogout(){
        Auth::logout();
        return Redirect()->route('login');
    }

    public function UserProfile(){
        $id = Auth::user()->id;
        $user= User::find($id);
        return view('frontend.profile.user_profile', compact('user'));
    }
    public function UserProfileStore(Request $request){
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;

        if($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('YmdHi').$file->getClientOriginalName(); //cu aceasta functie vom lua poza selectata si o vom pune in folderul
            $file->move(public_path('upload/user_images'),$filename);            // si o va pune in upload/admin_images   
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        $notif = array(
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard')->with($notif);
    }

    public function UserChangePassword(){
        $id = Auth::user()->id;
        $user= User::find($id);
        return view('frontend.profile.change_password',compact('user'));
    }

    public function UserPasswordUpdate(Request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){ //conditia acestui if verifica parolele din db cu cea introdusa daca exista
            $user= User::find(Auth::id());
            $user->password=Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        }
        else{
            return redirect()->back();
        }
    }
}