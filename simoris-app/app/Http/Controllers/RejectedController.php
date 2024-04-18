<?php

namespace App\Http\Controllers;

use App\Models\SuratIzin;
use App\Models\Individuals;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAccounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RejectedController extends Controller
{
    public function index(){
        $user = Auth::user();
        $sertifikasi = Sertifikasi::where('individuals_id', $user->individual['id'])->first();
        $suratizin = SuratIzin::where('individuals_id', $user->individual['id'])->first();
        $statusSertif = $sertifikasi->is_accepted;
        $statusSuratIzin = $suratizin->is_accepted;

        return view('general.layouts.edit', compact('sertifikasi', 'suratizin', 'statusSertif', 'statusSuratIzin'));
    }

    public function update(Request $request){
        $user_id = Auth::user()->id;
        $profil = Individuals::where('id', $user_id)->first();

        $oldSertifikasi = Sertifikasi::where('individuals_id', $profil->id)->value('bukti');
        $oldSuratIzin = SuratIzin::where('individuals_id', $profil->id)->value('bukti');
    
        if ($oldSertifikasi) {
            Storage::disk('public')->delete($oldSertifikasi);
        } else if ($oldSuratIzin) {
            Storage::disk('public')->delete($oldSuratIzin);
        }

        if ($request->hasFile('bukti_sertifikasi')) {
            $buktiSertifikasi = $request->file('bukti_sertifikasi')->storeAs(
                'bukti_sertifikasi',$request->file('bukti_sertifikasi')->getClientOriginalName(),'public');
            Sertifikasi::where('individuals_id', $profil->id)->update([
                'bukti' => $buktiSertifikasi
            ]);
        } else if ($request->hasFile('bukti_suratizin')) {
            $buktiSuratizin = $request->file('bukti_suratizin')->storeAs(
                'bukti_suratizin',$request->file('bukti_suratizin')->getClientOriginalName(),'public');
            SuratIzin::where('individuals_id', $profil->id)->update([
                'bukti' => $buktiSuratizin
            ]);
        }

        // dd($request->all());
        // dd($request['tanggal-expired-suratizin']);
        Sertifikasi::where('individuals_id', $profil->id)->update([
            'nomor_sertifikasi' => $request->no_sertifikasi,
            'tanggal_pembuatan' => $request['tanggal-pembuatan-sertif'],
            'tanggal_expired' => $request['tanggal-expired-sertif']
        ]);
        SuratIzin::where('individuals_id', $profil->id)->update([
            'nomor_surat' => $request->no_suratizin,
            'tanggal_pembuatan' => $request['tanggal-pembuatan-suratizin'],
            'tanggal_expired' => $request['tanggal-expired-suratizin']
        ]); 

        UserAccounts::where('id', Auth::user()->id)->update([
            'status' => 'pending'
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $session = session();
        $session->flash('update', 'Anda Berhasil Mengedit Pengajuan Anda, Cek Secara Berkala');
        return redirect('/');
    }

    public function back(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
