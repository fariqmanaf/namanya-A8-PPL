<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Individuals;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PeternakProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Beranda';
        $name = Individuals::where('id', Auth::user()->individuals_id)->first();

        return view('peternak.layouts.beranda', compact('title', 'name'));
    }

    public function changepass(Request $request)
    {
        $name = Individuals::where('id', Auth::user()->individuals_id)->first();

        return view('peternak.layouts.changepass', compact('name'));
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
                return redirect('/main/profile/edit')->with('error','Password Lama Anda Salah');
            }
    
            return redirect('/main/profile/edit')->with('success', 'Password Anda Sudah Diperbarui');
        } catch (ValidationException $e) {
            return redirect('/main/profile/edit')->with('error','Password Lama Anda Salah');
        }
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
    // public function show()
    // {
    //     $user_id = Auth::user()->id;
    //     $akun = UserAccounts::where('id', $user_id)->first();
    //     $profil = Individuals::where('id', $user_id)->first();
    //     $alamat = Alamat::where('id', $user_id)->first();
    //     $kabupaten = Kabupaten::where('id', $alamat->kabupaten_id)->first();
    //     $kecamatan = Kecamatan::where('id', $alamat->kecamatan_id)->first();
    //     $kelurahan = Kelurahan::where('id', $alamat->kelurahan_id)->first();

    //     return view('peternak.layouts.profile', compact('akun', 'profil', 'alamat', 'kabupaten', 'kecamatan', 'kelurahan'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
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

        return view('peternak.layouts.editprofile', compact('akun', 'profil', 'alamat', 'kabupaten', 'kecamatan', 'kelurahan', 'kabupatenuser', 'kecamatanuser', 'kelurahanuser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // @dd($request->all());

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

        return redirect('/main/profile')->with('success', 'Profil Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
