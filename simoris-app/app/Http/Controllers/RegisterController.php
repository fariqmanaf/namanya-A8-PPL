<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Individuals;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Sertifikasi;
use App\Models\SuratIzin;
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
            'tanggal-lahir' => 'required|date',
            'notelp' => 'required|numeric',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detail' => 'required',
            'password' => 'required|min:8|max:255',
            'roles_id' => 'required',
            'status' => 'required'
        ]);

        $defaultStatus = 'enable';
        $defaultRolesId = 3;

        $status = $request->input('status') === 'random' ? $defaultStatus : $defaultStatus;
        $roles_id = $request->input('roles_id') === 'random' ? $defaultRolesId : $defaultRolesId;

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
            'alamats_id' => $alamat
        ]);

        UserAccounts::create([
            'individuals_id' => $individual,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'status' => $status,
            'roles_id' => $roles_id,
        ]);

        $request = session();
        $request->flash('success', 'Anda Berhasil Registrasi, Silahkan Login');
        return redirect('/');
    }

    public function storeMantri(Request $request){
        // @dd($request->all());
        $validatedData = $request->validate([
            'nik' => 'required|unique:individuals',
            'email' => 'required|email:dns|unique:user_accounts',
            'nama' => 'required|max:255|min:3',
            'tanggal-lahir' => 'required|date',
            'notelp' => 'required|numeric',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detail' => 'required',
            'password' => 'required|min:8|max:255',
            'roles_id' => 'required',
            'status' => 'required',
            'no_sertifikasi' => 'required',
            'bukti_sertifikasi' => 'required|image|file|max:2048',
            'no_suratizin' => 'required',
            'bukti_suratizin' => 'required|image|file|max:2048',
            // 'wilayah_kerja' => 'required',
            'is_accepted_sertifikasi' => 'required',
            'is_accepted_suratizin' => 'required',
        ]);

        $defaultStatus = 'pending';
        $defaultRolesId = 2;
        $defaultSertifikasi = 0;
        $defaultSuratIzin = 0;
        
        $status = $request->input('status') === 'random' ? $defaultStatus : $defaultStatus;
        $roles_id = $request->input('roles_id') === 'random' ? $defaultRolesId : $defaultRolesId;
        $is_accepted_sertifikasi = $request->input('is_accepted_sertifikasi') === 'random' ? $defaultSertifikasi : $defaultSertifikasi;
        $is_accepted_suratizin = $request->input('is_accepted_suratizin') === 'random' ? $defaultSuratIzin : $defaultSuratIzin;

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
            'alamats_id' => $alamat
        ]);

        UserAccounts::create([
            'individuals_id' => $individual,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'status' => $status,
            'roles_id' => $roles_id,
        ]);

        Sertifikasi::create([
            'nomor_sertifikasi' => $validatedData['no_sertifikasi'],
            'bukti' => $validatedData['bukti_sertifikasi'],
            'is_accepted' => $is_accepted_sertifikasi,
            'individuals_id' => $individual
        ]);

        SuratIzin::create([
            'nomor_surat' => $validatedData['no_suratizin'],
            'bukti' => $validatedData['bukti_suratizin'],
            'is_accepted' => $is_accepted_suratizin,
            'individuals_id' => $individual
        ]);

        if($request->file('bukti_sertifikasi')){
            $validatedData['bukti_sertifikasi'] = $request->file('bukti_sertifikasi')->store('bukti_serifikasi');
        }

        if($request->file('bukti_suratizin')){
            $validatedData['bukti_suratizin'] = $request->file('bukti_suratizin')->store('bukti_suratizin');
        }

        $request = session();
        $request->flash('success', 'Anda Berhasil Registrasi, Akun Anda Sedang Di Proses Oleh Dinas. Silahkan Mengeceknya Secara Berkala');
        return redirect('/');
    }
}
