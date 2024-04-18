<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\SuratIzin;
use App\Models\Individuals;
use App\Models\Sertifikasi;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MantriProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Beranda';
        $name = Individuals::where('id', Auth::user()->individuals_id)->first();

        return view('mantri.layouts.beranda', compact('title', 'name'));
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
     * Store a newly created resource in storage.
     */
    public function changepass(Request $request)
    {
        $name = Individuals::where('id', Auth::user()->individuals_id)->first();

        return view('mantri.layouts.changepass', compact('name'));
    }

    public function updatepass(Request $request)
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
            return redirect('/home/profile/changepass')->withErrors('Password Lama Anda Salah');
        }

        return redirect('/home/profile/changepass')->with('success', 'Password Anda Sudah Diperbarui');
    }

    public function edit()
    {
        $user_id = Auth::user()->individuals_id;
        $akun = UserAccounts::where('id', $user_id)->first();
        $profil = Individuals::where('id', $user_id)->first();
        $alamat = $profil->alamat;
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();
        $kabupatenuser = Kabupaten::where('id', $alamat['kabupaten_id'])->first();
        $kecamatanuser = Kecamatan::where('id', $alamat->kecamatan_id)->first();
        $kelurahanuser = Kelurahan::where('id', $alamat->kelurahan_id)->first();

        return view('mantri.layouts.editprofile', compact('akun', 'profil', 'alamat', 'kabupaten', 'kecamatan', 'kelurahan', 'kabupatenuser', 'kecamatanuser', 'kelurahanuser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $alamatData = $request->validate([
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'detail' => 'required'
        ]);

        $individuals_user = Individuals::where('id', Auth::user()->individuals_id)->first();
        $profilData = $request->validate([
            'nik' => ['required', Rule::unique('individuals')->ignore($individuals_user, 'nik')],
            'name' => 'required|max:255|min:3',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'required|numeric'
        ]); 

        $akunrules = [
            'email' => ['required','email:dns', Rule::unique('user_accounts')->ignore(Auth::user()->email, 'email')],
        ];
        
        $validatedData = $request->validate($akunrules);

        // if (isset($validatedData['password'])) {
        //     $validatedData['password'] = Hash::make($validatedData['password']);
        // }

        UserAccounts::where('id', Auth::user()->id)
            ->update($validatedData);
        Individuals::where('id', Auth::user()->individuals_id)
            ->update($profilData);
        Alamat::where('id', $individuals_user->alamats_id)
            ->update($alamatData);

        return redirect('/home/profile')->with('success', 'Account Has Been Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
