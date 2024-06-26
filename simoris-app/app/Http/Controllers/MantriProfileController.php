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
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MantriProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Beranda';

        return view('mantri.layouts.beranda', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dokumenMantri()
    {
        $title = 'Dokumen Mantri';
        $sertifikasi = Sertifikasi::where('individuals_id', Auth::user()->individuals_id)->first();
        $suratIzin = SuratIzin::where('individuals_id', Auth::user()->individuals_id)->first();

        return view('mantri.layouts.dokumenMantri', compact('title', 'sertifikasi', 'suratIzin'));
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
        try{
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|max:255'],
            [
                'new_password.min' => 'Kata sandi minimal harus :min karakter.',
                'new_password.max' => 'Kata sandi maksimal :max karakter.',
                'new_password.required' => 'Kata sandi baru tidak boleh kosong.',
                'old_password.required' => 'Kata sandi lama tidak boleh kosong.'
            ]);
        
            if (Hash::check($request->old_password, Auth::user()->password)) {
                $password = Hash::make($request->new_password);
                UserAccounts::where('id', Auth::user()->id)
                    ->update(['password' => $password]);
            }
            else{
                return redirect('/home/profile/changepass')->with('error','Password Lama Anda Salah');
            }
    
            return redirect('/home/profile/changepass')->with('success', 'Password Anda Sudah Diperbarui');
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return back()->withErrors($errors)->withInput();
        }
    }

    public function edit()
    {
        $user_id = Auth::user()->id;
        $akun = UserAccounts::where('id', $user_id)->first();
        $profil = Individuals::where('id', $user_id)->first();
        $alamat = Alamat::where('id', $user_id)->first();
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();
        $kabupatenuser = Kabupaten::where('id', $alamat->kabupaten_id)->first();
        $kecamatanuser = Kecamatan::where('id', $alamat->kecamatan_id)->first();
        $kelurahanuser = Kelurahan::where('id', $alamat->kelurahan_id)->first();

        return view('mantri.layouts.editprofile', compact('akun', 'profil', 'alamat', 'kabupaten', 'kecamatan', 'kelurahan', 'kabupatenuser', 'kecamatanuser', 'kelurahanuser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
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
    
            UserAccounts::where('id', Auth::user()->id)
                ->update($validatedData);
            Individuals::where('id', Auth::user()->individuals_id)
                ->update($profilData);
            Alamat::where('id', $individuals_user->alamats_id)
                ->update($alamatData);
    
            return redirect('/home/profile')->with('success', 'Profil Berhasil Diperbarui!');
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return back()->withErrors($errors)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
