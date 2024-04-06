<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\SuratIzin;
use App\Models\Sertifikasi;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterMantriController extends Controller
{
    public function mregist1() {
        return view('mantri.layouts.register-1');
    }

    public function mregist2(Kecamatan $kecamatan, Kabupaten $kabupaten, Kelurahan $kelurahan) {
        return view('mantri.layouts.register-2',[
            'kecamatan' => $kecamatan->all(),
            'kabupaten' => $kabupaten->all(),
            'kelurahan' => $kelurahan->all()
        ]);
    }

    public function mregist3(Kecamatan $kecamatan) {
        return view('mantri.layouts.register-3', [
            'kecamatan' => $kecamatan->all(),
        ]);
    }

    public function storeMantri1(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email:dns|unique:user_accounts',
            'password' => 'required|min:8|max:255',
            'roles_id' => 'required',
            'status' => 'required',
        ]);

        $defaultStatus = 'pending';
        $defaultRolesId = 2;
        $status = $request->input('status') === 'random' ? $defaultStatus : $defaultStatus;
        $roles_id = $request->input('roles_id') === 'random' ? $defaultRolesId : $defaultRolesId;

        session()->put('registration.email', $validatedData['email']);
        session()->put('registration.password', $validatedData['password']);
        session()->put('registration.roles_id', $roles_id);
        session()->put('registration.status', $status);
    
        return redirect('/register/mantri/step-2');
    }

    public function storeMantri2(Request $request){
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

        session()->put('registration.nama', $validatedData['nama']);
        session()->put('registration.nik', $validatedData['nik']);
        session()->put('registration.tanggal-lahir', $validatedData['tanggal-lahir']);
        session()->put('registration.notelp', $validatedData['notelp']);
        session()->put('registration.kabupaten', $validatedData['kabupaten']);
        session()->put('registration.kecamatan', $validatedData['kecamatan']);
        session()->put('registration.kelurahan', $validatedData['kelurahan']);
        session()->put('registration.detail', $validatedData['detail']);
    
        return redirect('/register/mantri/step-3');
    }

    public function storeMantri3(Request $request){
        $validatedData = $request->validate([
            'wilayah_kerja' => 'required',
            'no_sertifikasi' => 'required',
            'bukti_sertifikasi' => 'required|image|file|max:2048',
            'no_suratizin' => 'required',
            'bukti_suratizin' => 'required|image|file|max:2048',
            'is_accepted_sertifikasi' => 'required',
            'is_accepted_suratizin' => 'required',
        ]);

        $defaultSertifikasi = 0;
        $defaultSuratIzin = 0;
        $is_accepted_sertifikasi = $request->input('is_accepted_sertifikasi') === 'random' ? $defaultSertifikasi : $defaultSertifikasi;
        $is_accepted_suratizin = $request->input('is_accepted_suratizin') === 'random' ? $defaultSuratIzin : $defaultSuratIzin;

        if ($request->hasFile('bukti_sertifikasi')) {
            $buktiSertifikasi = $request->file('bukti_sertifikasi')->storeAs(
                'bukti_sertifikasi',$request->file('bukti_sertifikasi')->getClientOriginalName(),'public');
        } else {$buktiSertifikasi = null;}
        
        if ($request->hasFile('bukti_suratizin')) {
            $buktiSuratizin = $request->file('bukti_suratizin')->storeAs(
                'bukti_suratizin',$request->file('bukti_suratizin')->getClientOriginalName(),'public');
        } else {$buktiSuratizin = null;}

        $alamat = DB::table('alamats')->insertGetId([
            'kabupaten_id' => session()->get('registration.kabupaten'),
            'kecamatan_id' => session()->get('registration.kecamatan'),
            'kelurahan_id' => session()->get('registration.kelurahan'),
            'detail' => session()->get('registration.detail'),
        ]);

        $individual = DB::table('individuals')->insertGetId([
            'nik' => session()->get('registration.nik'),
            'name' => session()->get('registration.nama'),
            'tgl_lahir' => session()->get('registration.tanggal-lahir'),
            'no_telp' => session()->get('registration.notelp'),
            'alamats_id' => $alamat,
            'wilayah_kerja' => $validatedData['wilayah_kerja']
        ]);

        UserAccounts::create([
            'individuals_id' => $individual,
            'email' => session()->get('registration.email'),
            'password' => bcrypt(session()->get('registration.password')),
            'status' => session()->get('registration.status'),
            'roles_id' => session()->get('registration.roles_id'),
        ]);

        Sertifikasi::create([
            'nomor_sertifikasi' => $validatedData['no_sertifikasi'],
            'bukti' => $buktiSertifikasi,
            'is_accepted' => $is_accepted_sertifikasi,
            'individuals_id' => $individual
        ]);

        SuratIzin::create([
            'nomor_surat' => $validatedData['no_suratizin'],
            'bukti' => $buktiSuratizin,
            'is_accepted' => $is_accepted_suratizin,
            'individuals_id' => $individual
        ]);

        session()->forget('registration');
        $request = session();
        $request->flash('success', 'Anda Berhasil Registrasi, Akun Anda Sedang Di Proses Oleh Dinas. Silahkan Mengeceknya Secara Berkala');
        return redirect('/');
    }
}
