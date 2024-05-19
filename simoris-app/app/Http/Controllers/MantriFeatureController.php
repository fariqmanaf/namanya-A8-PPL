<?php

namespace App\Http\Controllers;

use App\Models\StokSb;
use App\Models\DataSapi;
use App\Models\JenisSapi;
use App\Models\Kecamatan;
use App\Models\LaporanIb;
use App\Models\JenisSemen;
use App\Models\StokMantri;
use App\Models\Individuals;
use App\Models\PengajuanSb;
use App\Models\UserAccounts;
use App\Models\WilayahKerja;
use Illuminate\Http\Request;
use App\Models\DetailPengajuan;
use Illuminate\Support\Facades\DB;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

        $presentaseMantri = StokMantri::where('individuals_id', Auth::user()->individual['id'])->get();
        $totalStok = $presentaseMantri->sum('total');
        $usedStok = $presentaseMantri->sum('used');
        $percentage = ($usedStok / $totalStok) * 100;

        return view('mantri.layouts.distribusi', [
            'title' => 'Monitoring Distribusi',
            'data' => $latestData,
            'subdata' => $subdata,
            'riwayatStok' => $riwayatStok,
            'periode' => $previousPeriod,
            'percentage' => $percentage
        ]);
    }

    public function indexPost(Request $request){

        $wilayahKerja = WilayahKerja::where('individuals_id', Auth::user()->individual['id'])->first();
        $stok = StokSb::where('kecamatan_id', $wilayahKerja->kecamatan_id)
            ->where('status', 'aktif')
            ->get();

        try {
            $validatedData = $request->validate([
                'total_stok' => 'required|numeric',
                'Simental' => 'required|numeric',
                'PO' => 'required|numeric',
                'Brahma' => 'required|numeric',
                'Limosin' => 'required|numeric',
            ],[
                'total_stok.required' => 'Data Tidak Lengkap',
                'total_stok.numeric' => 'Data Harus Berupa Angka',
                'Simental.required' => 'Data Tidak Lengkap',
                'Simental.numeric' => 'Data Harus Berupa Angka',
                'PO.required' => 'Data Tidak Lengkap',
                'PO.numeric' => 'Data Harus Berupa Angka',
                'Brahma.required' => 'Data Tidak Lengkap',
                'Brahma.numeric' => 'Data Harus Berupa Angka',
                'Limosin.required' => 'Data Tidak Lengkap',
                'Limosin.numeric' => 'Data Harus Berupa Angka',
            ]);

            if(($validatedData['PO'] / $validatedData['total_stok']) * 100 < 10){
                Toastr::error('Total PO tidak mencapai 10% dari total stok', 'Error');
                return back();
            }elseif($validatedData['total_stok'] != ($validatedData['Simental'] + $validatedData['PO'] + $validatedData['Brahma'] + $validatedData['Limosin'])){
                Toastr::error('Total stok tidak sesuai', 'Error');
                return back();
            }else{
                foreach($stok as $item){
                    if(($item->jumlah - $item->used) < $validatedData[$item->jenis_sapi['jenis_semen']]){
                        Toastr::error('Stok tidak mencukupi', 'Error');
                        return back();
                    } else{
                        $jumlah = [$validatedData['Limosin'], $validatedData['Simental'], $validatedData['Brahma'], $validatedData['PO']]; 
                        $total = $validatedData['total_stok'];
                        $pengajuanSb = DB::table('pengajuan_sb')->insertGetId([
                            'individuals_id' => Auth::user()->individual['id'],
                            'total' => $total,
                            'is_taken' => 0,
                            'is_confirmed' => 0,
                            'tanggal' => date('Y-m-d'),
                        ]);
                        
                        foreach($jumlah as $i => $jumlahItem){
                            DetailPengajuan::create([
                                'pengajuan_sb_id' => $pengajuanSb,
                                'jenis_semen_id' => $i + 1,
                                'jumlah' => $jumlahItem,
                            ]);
                        }
                        Toastr::success('Data berhasil disimpan menunggu konfirmasi dinas', 'Sukses');
                        return back();
                    }
                }
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return back()->withErrors($errors)->withInput();
        }
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
        ],[
            'jenisSapi.required' => 'Data Tidak Lengkap',
            'ciri.required' => 'Data Tidak Lengkap',
        ]);

        DataSapi::create([
            'jenis_sapi_id' => $validatedData['jenisSapi'],
            'individuals_id' => $request['id'],
            'detail' => $validatedData['ciri'],
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
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
        
        StokMantri::where('individuals_id', Auth::user()->individual['id'])->where('jenis_semen_id', $validatedData['jenisSemen'])
            ->update([
                'used' => StokMantri::where('individuals_id', Auth::user()->individual['id'])->where('jenis_semen_id', $validatedData['jenisSemen'])->value('used') + 1,
                'total' => StokMantri::where('individuals_id', Auth::user()->individual['id'])->where('jenis_semen_id', $validatedData['jenisSemen'])->value('total') - 1
            ]);

        return redirect()->back()->with('success', 'Data IB berhasil disimpan');
    }

    public function editIb(Request $request){
        $validatedData = $request->validate([
            'statusBunting' => 'required',
            'tanggalCek' => 'required|date'
        ], [
            'statusBunting.required' => 'Data Tidak Lengkap',
            'tanggalCek.required' => 'Data Tidak Lengkap'
        ]);

        $laporanIB = LaporanIb::find($request['laporanId']);
        $laporanIB->status_bunting = $validatedData['statusBunting'];
        $laporanIB->tgl_cek = $validatedData['tanggalCek'];
        $laporanIB->save();

        return redirect()->back()->with('success', 'Data Berhasil Ditambah');
    }

    public function riwayatIB(){
        $title = 'Riwayat IB';
        $laporanIB = LaporanIb::where('id_mantri', Auth::user()->id)->orderByDesc('tgl_ib')->get();
        $peternak = Individuals::whereIn('id', $laporanIB->pluck('id_peternak'))->get();

        return view('mantri.layouts.riwayatIB', compact('title', 'laporanIB', 'peternak'));
    }

    public function riwayatPengajuan(){
        $title = 'Riwayat Pengajuan';
        
        $notPending = PengajuanSb::where('individuals_id', Auth::user()->individual['id'])->where('is_confirmed', '!=', 0)->orderByDesc('tanggal')->get();
        $pending = PengajuanSb::where('individuals_id', Auth::user()->individual['id'])->where('is_confirmed', 0)->get();

        return view('mantri.layouts.riwayatPengajuan', compact('title', 'pending', 'notPending'));
    }

    public function riwayatPost(Request $request){
        $wilayahKerja = WilayahKerja::where('individuals_id', Auth::user()->individual['id'])->first();
        $stok = StokSb::where('kecamatan_id', $wilayahKerja->kecamatan_id)
            ->where('status', 'aktif')
            ->get();
            
        try {
            $validatedData = $request->validate([
                'pengajuan_id' => 'required|numeric',
                'total_stok' => 'required|numeric',
                'Simental' => 'required|numeric',
                'PO' => 'required|numeric',
                'Brahma' => 'required|numeric',
                'Limosin' => 'required|numeric',
            ],[
                'total_stok.required' => 'Data Tidak Lengkap',
                'total_stok.numeric' => 'Data Harus Berupa Angka',
                'Simental.required' => 'Data Tidak Lengkap',
                'Simental.numeric' => 'Data Harus Berupa Angka',
                'PO.required' => 'Data Tidak Lengkap',
                'PO.numeric' => 'Data Harus Berupa Angka',
                'Brahma.required' => 'Data Tidak Lengkap',
                'Brahma.numeric' => 'Data Harus Berupa Angka',
                'Limosin.required' => 'Data Tidak Lengkap',
                'Limosin.numeric' => 'Data Harus Berupa Angka',
            ]);

            if(($validatedData['PO'] / $validatedData['total_stok']) * 100 < 10){
                Toastr::error('Total PO tidak mencapai 10% dari total stok', 'Error');
                return back();
            }elseif($validatedData['total_stok'] != ($validatedData['Simental'] + $validatedData['PO'] + $validatedData['Brahma'] + $validatedData['Limosin'])){
                Toastr::error('Total stok tidak sesuai', 'Error');
                return back();
            }else{
                foreach($stok as $item){
                    if($item->jumlah < $validatedData[$item->jenis_sapi['jenis_semen']]){
                        Toastr::error('Stok tidak mencukupi', 'Error');
                        return back();
                    } else{
                        $jumlah = [$validatedData['Limosin'], $validatedData['Simental'], $validatedData['Brahma'], $validatedData['PO']]; 
                        PengajuanSb::where('individuals_id', Auth::user()->individual['id'])
                        ->where('id', $validatedData['pengajuan_id'])
                        ->update([
                            'total' => $validatedData['total_stok'],
                        ]);
                        foreach($jumlah as $i => $jumlahItem){
                            DetailPengajuan::where('pengajuan_sb_id', $validatedData['pengajuan_id'])
                            ->where('jenis_semen_id', $i + 1)
                            ->update([
                                'jumlah' => $jumlahItem,
                            ]);
                        }
                        Toastr::success('Data berhasil disimpan menunggu konfirmasi dinas', 'Sukses');
                        return back();
                    }
                }
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            foreach ($errors->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return back()->withErrors($errors)->withInput();
        }
    }
}
