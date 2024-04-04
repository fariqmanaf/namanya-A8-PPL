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
        $user_id = Auth::user()->id;
        $profil = Individuals::where('id', $user_id)->first();
        $sertifikasi = Sertifikasi::where('individuals_id', $profil->id)->first();
        $suratizin = SuratIzin::where('individuals_id', $profil->id)->first();

        return view('general.layouts.edit', compact('sertifikasi', 'suratizin'));
    }

    public function update(Request $request){
        // @dd($request->all());
        $user_id = Auth::user()->id;
        $profil = Individuals::where('id', $user_id)->first();

        $perizinan = $request->validate([
            'no_sertifikasi' => 'required',
            'no_suratizin' => 'required',
            'bukti_sertifikasi' => 'image|max:2048',
            'bukti_suratizin' => 'image|max:2048'
        ]);

        $defaultSertifikasi = 0;
        $defaultSuratIzin = 0;
        $is_accepted_sertifikasi = $request->input('is_accepted_sertifikasi') === 'random' ? $defaultSertifikasi : $defaultSertifikasi;
        $is_accepted_suratizin = $request->input('is_accepted_suratizin') === 'random' ? $defaultSuratIzin : $defaultSuratIzin;

        $oldSertifikasi = Sertifikasi::where('individuals_id', $profil->id)->value('bukti');
        $oldSuratIzin = SuratIzin::where('individuals_id', $profil->id)->value('bukti');
    
        if ($oldSertifikasi) {
            Storage::disk('public')->delete($oldSertifikasi);
        }
    
        if ($oldSuratIzin) {
            Storage::disk('public')->delete($oldSuratIzin);
        }

        if ($request->hasFile('bukti_sertifikasi')) {
            $buktiSertifikasi = $request->file('bukti_sertifikasi')->storeAs(
                'bukti_sertifikasi',$request->file('bukti_sertifikasi')->getClientOriginalName(),'public');
            Sertifikasi::where('individuals_id', $profil->id)->update([
                'bukti' => $buktiSertifikasi
            ]);
        }
        
        if ($request->hasFile('bukti_suratizin')) {
            $buktiSuratizin = $request->file('bukti_suratizin')->storeAs(
                'bukti_suratizin',$request->file('bukti_suratizin')->getClientOriginalName(),'public');
            SuratIzin::where('individuals_id', $profil->id)->update([
                'bukti' => $buktiSuratizin
            ]);
        }

        Sertifikasi::where('individuals_id', $profil->id)->update([
            'nomor_sertifikasi' => $perizinan['no_sertifikasi'],
            'is_accepted' => $is_accepted_sertifikasi,
        ]);
        SuratIzin::where('individuals_id', $profil->id)->update([
            'nomor_surat' => $perizinan['no_suratizin'],
            'is_accepted' => $is_accepted_suratizin,
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
