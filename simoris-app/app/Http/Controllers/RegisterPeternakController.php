<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterPeternakController extends Controller
{
    public function pregist1() {
        return view('peternak.layouts.register-1');
    }

    public function pregist2(Kecamatan $kecamatan, Kabupaten $kabupaten, Kelurahan $kelurahan) {
        return view('peternak.layouts.register-2',[
            'kecamatan' => $kecamatan->all(),
            'kabupaten' => $kabupaten->all(),
            'kelurahan' => $kelurahan->all()
        ]);
    }
    
    public function storePeternak1(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email:dns|unique:user_accounts',
            'password' => 'required|min:8|max:255',
            'roles_id' => 'required',
            'status' => 'required',
        ]);

        $defaultStatus = 'enable';
        $defaultRolesId = 3;
        $status = $request->input('status') === 'random' ? $defaultStatus : $defaultStatus;
        $roles_id = $request->input('roles_id') === 'random' ? $defaultRolesId : $defaultRolesId;

        session()->put('registration.email', $validatedData['email']);
        session()->put('registration.password', $validatedData['password']);
        session()->put('registration.roles_id', $roles_id);
        session()->put('registration.status', $status);
    
        return redirect('/register/peternak/step-2');
    }

    public function storePeternak2(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required|max:255|min:3',
            'nik' => 'required|unique:individuals',
            'tanggal-lahir' => 'required|date',
            'notelp' => 'required|numeric',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detail' => 'required',
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
            'tgl_lahir' => $validatedData['tanggal-lahir'],
            'no_telp' => $validatedData['notelp'],
            'alamats_id' => $alamat,
            'wilayah_kerja' => ''
        ]);

        UserAccounts::create([
            'individuals_id' => $individual,
            'email' => session()->get('registration.email'),
            'password' => bcrypt(session()->get('registration.password')),
            'status' => session()->get('registration.status'),
            'roles_id' => session()->get('registration.roles_id'),
        ]);

        session()->forget('registration');
        $request = session();
        $request->flash('success', 'Anda Berhasil Registrasi, Silahkan Login');
        return redirect('/');
    }
}
