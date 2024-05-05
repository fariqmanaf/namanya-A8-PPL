<?php

namespace App\Http\Controllers;

use App\Models\StokSb;
use App\Models\DataSapi;
use App\Models\JenisSapi;
use App\Models\Kecamatan;
use App\Models\LaporanIb;
use App\Models\JenisSemen;
use App\Models\Individuals;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MantriFeatureController extends Controller
{
    public function index()
    {
        $latestPeriod = StokSb::select('periode')->orderByDesc('periode')->value('periode');
        $previousPeriod = StokSb::select('periode')->groupBy('periode')->orderBydesc('periode')->take(1)->value('periode');

        $latestData = StokSb::with('kecamatan')->selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::with('jenis_sapi')->selectRaw('jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'jenis_semen_id', 'jumlah')->get();

        $riwayatStok = StokSb::selectRaw('jenis_semen_id, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $previousPeriod)
            ->groupBy('jenis_semen_id')->get();

        return view('mantri.layouts.distribusi', [
            'title' => 'Dashboard',
            'data' => $latestData,
            'subdata' => $subdata,
            'riwayatStok' => $riwayatStok,
            'periode' => $previousPeriod
        ]);
    }

    public function laporanIB(){
        $title = 'Laporan IB';
        $dataPeternak = UserAccounts::where('roles_id', 3)->get();

        return view('mantri.layouts.laporanIB', compact('title', 'dataPeternak'));
    }

    public function dataSapi(Individuals $individuals){
        $title = 'Data Sapi';
        $profil = Individuals::find($individuals->id);
        $dataSapi = DataSapi::where('individuals_id', $individuals->id)->get();
        $jenisSapi = JenisSapi::all();

        return view('mantri.layouts.dataSapi', compact('title','dataSapi', 'profil', 'jenisSapi'));
    }

    public function dataSapiPost(Request $request){
        $validatedData = $request->validate([
            'jenisSapi' => 'required',
            'ciri' => 'required',
        ]);

        DataSapi::create([
            'jenis_sapi_id' => $validatedData['jenisSapi'],
            'individuals_id' => $request['id'],
            'detail' => $validatedData['ciri'],
        ]);

        return redirect()->back()->with('success', 'Data sapi berhasil ditambahkan');
    }

    public function ibSapi(Individuals $individuals, DataSapi $dataSapi){
        $title = 'Riwayat IB Sapi';
        $peternak = Individuals::find($individuals->id);
        $laporanIB = LaporanIb::where('data_sapi_id', $dataSapi->id)->get();
        $jenisSemen = JenisSemen::all();
        if($laporanIB->pluck('id_mantri')){
            $inseminator = Individuals::whereIn('id', $laporanIB->pluck('id_mantri'))->get();
        } else {$inseminator = null;}

        return view('mantri.layouts.IBsapi', compact('title', 'laporanIB', 'jenisSemen', 'peternak', 'inseminator'));
    }

    public function ibSapiPost(Request $request, Individuals $individuals, DataSapi $dataSapi){
        $validatedData = $request->validate([
            'jenisSemen' => 'required',
            'tanggalIB' => 'required|date',
        ]);

        LaporanIb::create([
            'jenis_semen_id' => $validatedData['jenisSemen'],
            'data_sapi_id' => $dataSapi->id,
            'tgl_ib' => $validatedData['tanggalIB'],
            'id_mantri' => Auth::user()->id,
            'id_peternak' => $individuals->id,
            'status_bunting' => 0,
        ]);

        return redirect()->back()->with('success', 'Data IB berhasil ditambahkan');
    }

    public function editIb(Request $request){
        $validatedData = $request->validate([
            'statusBunting' => 'required',
            'tanggalCek' => 'required|date'
        ]);

        $laporanIB = LaporanIb::find($request['laporanId']);
        $laporanIB->status_bunting = $validatedData['statusBunting'];
        $laporanIB->tgl_cek = $validatedData['tanggalCek'];
        $laporanIB->save();

        return redirect()->back()->with('success', 'Laporan Diperbarui');
    }

    public function riwayatIB(){
        $title = 'Riwayat IB';
        $laporanIB = LaporanIb::where('id_mantri', Auth::user()->id)->get();
        $peternak = Individuals::whereIn('id', $laporanIB->pluck('id_peternak'))->get();

        return view('mantri.layouts.riwayatIB', compact('title', 'laporanIB', 'peternak'));
    }
}
