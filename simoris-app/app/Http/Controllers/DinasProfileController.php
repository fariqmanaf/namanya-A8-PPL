<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DinasProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('dinas.layouts.changepass',[
            'title' => 'Ubah Password'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:255'],
        [
            'password.min' => 'Kata sandi minimal harus :min karakter.',
            'password.max' => 'Kata sandi maksimal :max karakter.',
        ]);
    
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $password = Hash::make($request->new_password);
            UserAccounts::where('id', Auth::user()->id)
                ->update(['password' => $password]);
        }
        else{
            return redirect('/dashboard/changepass')->withErrors('Password Lama Anda Salah');
        }
    
        return redirect('/dashboard/changepass')->with('success', 'Password Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
