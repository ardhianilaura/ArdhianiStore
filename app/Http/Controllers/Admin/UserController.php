<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Illuminate\Support\Facades\Auth;
use App\User;
 
class UserController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

    public function my_profile(){
    	return view('admin.my_profile');
    }

    public function my_profile_update(Request $request){
    	$data_swal = [
                'type' => 'success',
                'title' => 'yay',
        ];

    	$id = Auth::user()->id;
    	$user = User::findOrFail($id);
    	$user->name = $request->input('name');
    	$user->lname = $request->input('lname');
        $user->username = $request->input('username');
    	$user->email = $request->input('email');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
    	$user->alamat = $request->input('alamat');
    	$user->no_hp = $request->input('no_hp');

    	$user->update();
    	$data_swal['id'] = $id;
                $data_swal['message'] = 'Profile Updated';
                $data_swal['type'] = 'success';
                $data_swal['title'] = 'yayy!';
    	return redirect()->route('my_profile', $data_swal);
    }
}