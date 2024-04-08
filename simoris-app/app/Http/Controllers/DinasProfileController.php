<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'password' => 'nullable|min:8|max:255',
            'validation-password' => 'required_with:password|same:password'],
        [
            'password.min' => 'Kata sandi minimal harus :min karakter.',
            'password.max' => 'Kata sandi maksimal :max karakter.',
            'validation-password.required_with' => 'Konfirmasi kata sandi wajib diisi.',
            'validation-password.same' => 'Konfirmasi kata sandi tidak sama dengan kata sandi.',
        ]);
    
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
            UserAccounts::where('id', Auth::user()->id)
                ->update(['password' => $password]);
        }
    
        return redirect('/dashboard/changepass')->with('success', 'Password Has Been Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
