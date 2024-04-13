<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    public function index() {
      return view('general.layouts.login');
    }

    public function login(Request $request){
      $request->validate([
        'email' => 'required|email',
        'password' => 'required'
      ]);

      $credentials = [
        'email' => $request->email,
        'password' => $request->password
      ];

      if(Auth::attempt($credentials)){
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->roles_id === 1) {
            return redirect('/dashboard');
        } 
        else if($user->roles_id === 2 && $user->status === "enable") {
            return redirect('/home');
        } 
        else if($user->status === "disable"){
          return redirect('/register/mantri/edit')->withErrors('Perizinan Anda Sudah Kadaluarsa, Silahkan Perbarui');
        } 
        else if($user->status === "pending"){
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->withErrors('Akun anda masih dalam pengecekan dinas')->onlyInput('email');
        } 
        else if($user->status === "rejected"){
          return redirect('/register/mantri/edit')->withErrors('Pengajuan anda ditolak, silahkan edit pengajuan anda');
        } 
        else if($user->roles_id === 3){
            return redirect('/main');
        }
        else{
          return redirect('/');
        }
      }

      else{
        return redirect('')->withErrors('Data Yang Di Inputkan Salah')->withInput();
      }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
