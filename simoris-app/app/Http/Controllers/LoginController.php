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
      return view('general.layouts.main');
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
        if ($user->id_roles === 1) {
            return redirect('/dashboard');
        } elseif ($user->id_roles === 2) {
            return redirect('/home');
        } else if($user->id_roles === 3){
            return redirect('/main');
        }else{
          return redirect('/');
        }
      }

      else{
        return redirect('')->withErrors('Invalid credentials')->withInput();
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
