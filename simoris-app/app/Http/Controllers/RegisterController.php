<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Individuals;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index() {
        return view('general.layouts.register');
    }

    public function pregist(Kecamatan $kecamatan, Kabupaten $kabupaten, Kelurahan $kelurahan) {
        return view('peternak.layouts.register',[
            'kecamatan' => $kecamatan->all(),
            'kabupaten' => $kabupaten->all(),
            'kelurahan' => $kelurahan->all()
        ]);
    }

    public function mregist(Kecamatan $kecamatan, Kabupaten $kabupaten, Kelurahan $kelurahan) {
        return view('mantri.layouts.register',[
            'kecamatan' => $kecamatan->all(),
            'kabupaten' => $kabupaten->all(),
            'kelurahan' => $kelurahan->all()
        ]);
    }

    public function storePeternak(Request $request){
        // @dd($request->all());
        $validatedData = $request->validate([
            'nik' => 'required|unique:individuals',
            'email' => 'required|email:dns|unique:user_accounts',
            'nama' => 'required|max:255|min:3',
            // 'tanggal-lahir' => 'numeric',
            'notelp' => 'required|numeric',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detail' => 'required',
            'password' => 'required|min:8|max:255',
            'roles_id' => 'required',
            'status' => 'required'
        ]);

        $alamat = DB::table('alamats')->insertGetId([
            'kabupaten_id' => $validatedData['kabupaten'],
            'kecamatan_id' => $validatedData['kecamatan'],
            'kelurahan_id' => $validatedData['kelurahan'],
            'detail' => $validatedData['detail'],
        ]);


        $individual = DB::table('individuals')->insertGetId([
            'nik' => $validatedData['nik'],
            'name' => $validatedData['nama'],
            // 'tgl_lahir' => $validatedData['tanggal-lahir'],
            'no_telp' => $validatedData['notelp'],
            'alamats_id' => $alamat
        ]);

        UserAccounts::create([
            'individuals_id' => $individual,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'status' => $validatedData['status'],
            'roles_id' => $validatedData['roles_id'],
        ]);

        $request = session();
        $request->flash('success', 'Anda Berhasil Registrasi, Silahkan Login');
        return redirect('/');
    }
}
