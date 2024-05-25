<?php

namespace App\Http\Controllers;

use App\Models\StokSb;
use App\Models\Kecamatan;
use App\Models\LaporanIb;
use App\Models\JenisSemen;
use App\Models\StokMantri;
use App\Models\Individuals;
use App\Models\PengajuanSb;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestPeriod = StokSb::select('periode')->orderByDesc('periode')->value('periode');
        $previousPeriod = StokSb::select('periode')->groupBy('periode')->orderBydesc('periode')->skip(1)->take(1)->value('periode');

        $latestData = StokSb::with('kecamatan')->selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::with('jenis_sapi')->selectRaw('jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'jenis_semen_id', 'jumlah')->get();

        $latestSisa = StokSb::selectRaw('jenis_semen_id, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('jenis_semen_id')->get();

        $batch = StokSb::selectRaw('jenis_semen_id, kecamatan_id,  SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $previousPeriod)
            ->groupBy('jenis_semen_id', 'kecamatan_id')->get();

        return view('dinas.layouts.main', [
            'title' => 'Dashboard',
            'data' => $latestData,
            'subdata' => $subdata,
            'latestSisa' => $latestSisa,
            'batch' => $batch,
            'latestPeriod' => $latestPeriod,
            'previousPeriod' => $previousPeriod,
        ]);
    }

    public function riwayat()
    {

        $latestData = StokSb::where('status', 'nonaktif')->selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::where('status', 'nonaktif')->selectRaw('periode, jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
            ->groupBy('periode', 'kecamatan_id', 'jenis_semen_id', 'jumlah')->get();

        $superdata = StokSb::where('status', 'nonaktif')->selectRaw('periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->groupBy('periode')->get();

        return view('dinas.layouts.riwayat', [
            'title' => 'Riwayat Stok',
            'kecamatan' => Kecamatan::all(),
            'jenis_semen' => JenisSemen::all(),
            'data' => $latestData,
            'subdata' => $subdata,
            'superdata' => $superdata,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createStok(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'total_stok' => 'required|numeric',
                'Simental' => 'required|numeric',
                'PO' => 'required|numeric',
                'Brahma' => 'required|numeric',
                'Limosin' => 'required|numeric',
            ]);
    
            $total_sisa = request('sisa-1') + request('sisa-2') + request('sisa-3') + request('sisa-4');
            $total_stok = $validatedData['total_stok'] += $total_sisa;
            $Simental = $validatedData['Simental'] += request('sisa-1');
            $PO = $validatedData['PO'] += request('sisa-2');
            $Brahma = $validatedData['Brahma'] += request('sisa-3');
            $Limosin = $validatedData['Limosin'] += request('sisa-4');
    
            $totalJenis = $Simental + $PO + $Brahma + $Limosin;
    
            if ($total_stok != $totalJenis) {
                return redirect('/dashboard')->with('error','Total stok tidak sesuai dengan jumlah jenis semen');
            } else {
                session()->put('stok.total_stok', $total_stok);
                session()->put('stok.Simental', $Simental);
                session()->put('stok.PO', $PO);
                session()->put('stok.Brahma', $Brahma);
                session()->put('stok.Limosin', $Limosin);
    
                return redirect('/dashboard/preview');
            }
        }
        catch(\Exception $e){
            return redirect('/dashboard')->with('error','Terdapat Kesalahan Dalam Mengisi Data');
        }
    }

    public function preview(Request $request)
    {

        $jenisSemen = JenisSemen::all()->pluck('id')->toArray();
        $kecamatan = Kecamatan::all();

        $jenis = [session()->get('stok.Simental'), session()->get('stok.PO'), session()->get('stok.Brahma'), session()->get('stok.Limosin')];
        $percentage = [
            0.04, 0.02, 0.04, 0.04, 0.02,
            0.04, 0.02, 0.04, 0.02, 0.04,
            0.02, 0.04, 0.02, 0.04, 0.02,
            0.04, 0.04, 0.04, 0.04, 0.02,
            0.04, 0.02, 0.04, 0.02, 0.04,
            0.02, 0.04, 0.02, 0.04, 0.04,
            0.04
        ];

        $data = [];
        $subdata = [];

        foreach ($kecamatan as $i => $kec) {
            $persentase = $percentage[$i];
            $total_stok = 0;

            foreach ($jenis as $x => $jenisStok) {
                $jumlah = $jenisStok * $persentase;
                $total_stok += $jumlah;
                $subdata[] = (object) [
                    'kecamatan_id' => $kec,
                    'jenis_semen_id' => $jenisSemen[$x],
                    'jumlah' => floor($jumlah),
                    'sisa_stok' => floor($jumlah),
                ];
            }
            $data[] = (object)[
                'periode' => date('Y-m-d'),
                'kecamatan_id' => $kec,
                'total_stok' => floor($total_stok),
                'sisa_stok' => floor($total_stok),
            ];
        }

        return view('dinas.layouts.preview', [
            'kecamatan' => Kecamatan::all(),
            'jenis_semen' => JenisSemen::all(),
            'data' => $data,
            'subdata' => $subdata,
            'title' => 'Preview Stok',
        ]);
    }

    public function previewpost(Request $request)
    {

        $validatedData = $request->validate([
            'total_stok' => 'required',
            'Simental' => 'required',
            'PO' => 'required',
            'Brahma' => 'required',
            'Limosin' => 'required',
        ]);

        $Simental = $validatedData['Simental'];
        $PO = $validatedData['PO'];
        $Brahma = $validatedData['Brahma'];
        $Limosin = $validatedData['Limosin'];

        $jenis = [$Simental, $PO, $Brahma, $Limosin];
        $percentage = [
            0.04, 0.02, 0.04, 0.04, 0.02,
            0.04, 0.02, 0.04, 0.02, 0.04,
            0.02, 0.04, 0.02, 0.04, 0.02,
            0.04, 0.04, 0.04, 0.04, 0.02,
            0.04, 0.02, 0.04, 0.02, 0.04,
            0.02, 0.04, 0.02, 0.04, 0.04,
            0.04
        ];
        $kecamatan = Kecamatan::all()->pluck('id');
        $jenisSemen = JenisSemen::all()->pluck('id');
        $status = 'aktif';

        foreach ($jenis as $x => $jenisStok) {
            foreach ($kecamatan as $i => $kec) {
                $persentase = $percentage[$i];
                $jumlah = floor($jenisStok * $persentase);
                StokSb::create([
                    'periode' => date('Y-m-d'),
                    'kecamatan_id' => $kec,
                    'jenis_semen_id' => $jenisSemen[$x],
                    'jumlah' => $jumlah,
                    'used' => 0,
                    'status' => $status,
                ]);
            }
        }

        $latestPeriod = StokSb::select('periode')->orderByDesc('periode')->value('periode');
        $previousPeriod = StokSb::select('periode')->groupBy('periode')->orderBydesc('periode')->skip(1)->take(1)->value('periode');

        StokSb::where('periode', $previousPeriod)->update(['status' => 'nonaktif']);

        session()->forget('stok');
        return redirect('/dashboard')->with('success', 'Stok berhasil ditambahkan');
    }

    public function laporanIB()
    {
        $title = "Laporan IB";
        $mantri = UserAccounts::where('roles_id', 2)->where('status', 'enable')->get();

        return view('dinas.layouts.laporanIbDinas', compact('title', 'mantri'));
    }

    public function ibDetail(Individuals $individuals)
    {
        $title = "Detail Laporan IB";
        $data = Individuals::where('id', $individuals->id)->first();
        $laporanIB = LaporanIb::where('id_mantri', $individuals->id)->get();

        return view('dinas.layouts.ibDetail', compact('title', 'data', 'laporanIB'));
    }

    public function pengajuanStok(){
        $title = "Riwayat Pengajuan";
        $pending = PengajuanSb::where('is_confirmed', 0)->get();
        // $notPending = PengajuanSb::where('is_confirmed', "!=", 0)->get();

        return view('dinas.layouts.pengajuanStok', compact('title', 'pending'));
    }

    public function postPengajuan(Request $request){

        if($request['action'] == 'accept'){
            $user = Individuals::where('id', $request['userAcc'])->first();
            $stok = StokSb::where('kecamatan_id', $user->wilayah_kerja[0]->kecamatan_id)->where('status', 'aktif')->get();
            $stokMantri = StokMantri::where('individuals_id', $request['userAcc'])->get();

            foreach($stok as $value){
                if(($value->jumlah - $value->used) < $request['jenis-acc-'.$value->jenis_semen_id]){
                    return redirect()->back()->with('error', 'Stok tidak mencukupi');
                }else{
                    PengajuanSb::where('id', $request['idAcc'])->update(['is_confirmed' => 1]);
                    foreach($stok as $stokUpdate){
                        StokSb::where('kecamatan_id', $user->wilayah_kerja[0]->kecamatan_id)->where('jenis_semen_id', $stokUpdate->jenis_semen_id)->update(['used' => $stokUpdate->used + $request['jenis-acc-'.$stokUpdate->jenis_semen_id]]);
                    }
                    if($stokMantri->isEmpty()){
                        foreach($stok as $stokMantriCreate){
                            StokMantri::create([
                                'individuals_id' => $request['userAcc'],
                                'jenis_semen_id' => $stokMantriCreate->jenis_semen_id,
                                'total' => $request['jenis-acc-'.$stokMantriCreate->jenis_semen_id],
                                'used' => 0
                            ]);
                        }
                    }else{
                        foreach($stokMantri as $stokMantriUpdate){
                            $stokMantriUpdate->where('jenis_semen_id', $stokMantriUpdate->jenis_semen_id)->update(['total' => $stokMantriUpdate->total + $request['jenis-acc-'.$stokMantriUpdate->jenis_semen_id]]);
                        }
                    }
                    return redirect()->back()->with('success', 'Pengajuan berhasil diterima');
                }
            }
        }
        
        elseif($request['action'] == 'reject'){
            PengajuanSb::where('id', $request['idReject'])->update(['is_confirmed' => 2]);
            return redirect()->back()->with('success', 'Pengajuan berhasil ditolak');
        }
    }

    public function pengambilanStok(){
        $title = 'Pengambilan Stok';
        $pengambilan = PengajuanSb::where('is_confirmed', 1)->where('is_taken', 0)->get();

        return view('dinas.layouts.pengambilanSb', compact('title', 'pengambilan'));
    }

    public function pengambilanPost(Request $request){
        PengajuanSb::where('id', $request['id'])->update(['is_taken' => 1]);
        return redirect()->back()->with('success', 'Pengambilan stok berhasil');
    }

    public function confirmedPengajuan(){
        $title = 'Pengajuan Diterima';
        $confirmed = PengajuanSb::where('is_confirmed', 1)->where('is_taken', 1)->get();

        return view('dinas.layouts.confirmedSb', compact('title', 'confirmed'));
    }

    public function rejectedPengajuan(){
        $title = 'Pengajuan Ditolak';
        $rejected = PengajuanSb::where('is_confirmed', 2)->get();

        return view('dinas.layouts.rejectedSb', compact('title', 'rejected'));
    }


    public function akumulasi()
    {
        $title = 'Akumulasi Keberhasilan';
        $currentYear = date('Y');
        $years = LaporanIb::selectRaw('YEAR(tgl_ib) as year')->distinct()->orderByDesc('year')->get()->pluck('year');
        $periods = [
            ['start' => "{$currentYear}-01-01", 'end' => "{$currentYear}-04-01"],
            ['start' => "{$currentYear}-04-01", 'end' => "{$currentYear}-07-01"],
            ['start' => "{$currentYear}-07-01", 'end' => "{$currentYear}-10-01"],
            ['start' => "{$currentYear}-10-01", 'end' => "{$currentYear}-12-01"],
        ];

        $akumulasi = [];
        foreach ($periods as $period) {
            $akumulasi[] = LaporanIb::where('status_bunting', 1)
                ->whereBetween('tgl_ib', [$period['start'], $period['end']])
                ->selectRaw('jenis_semen_id, SUM(status_bunting) as total')
                ->groupBy('jenis_semen_id')
                ->orderBy('jenis_semen_id')
                ->get()
                ->pluck('total');
        }

        return view('dinas.layouts.akumulasi', compact('title', 'akumulasi', 'years', 'currentYear'));
    }

    public function showByYear($year)
    {
        $title = 'Akumulasi Keberhasilan';
        $years = LaporanIb::selectRaw('YEAR(tgl_ib) as year')->distinct()->orderByDesc('year')->get()->pluck('year');
        $currentYear = $year;
        $periods = [
            ['start' => "{$currentYear}-01-01", 'end' => "{$currentYear}-04-01"],
            ['start' => "{$currentYear}-04-01", 'end' => "{$currentYear}-07-01"],
            ['start' => "{$currentYear}-07-01", 'end' => "{$currentYear}-10-01"],
            ['start' => "{$currentYear}-10-01", 'end' => "{$currentYear}-12-01"],
        ];

        $akumulasi = [];
        foreach ($periods as $period) {
            $akumulasi[] = LaporanIb::where('status_bunting', 1)
                ->whereBetween('tgl_ib', [$period['start'], $period['end']])
                ->selectRaw('jenis_semen_id, SUM(status_bunting) as total')
                ->groupBy('jenis_semen_id')
                ->orderBy('jenis_semen_id')
                ->get()
                ->pluck('total');
        }

        return view('dinas.layouts.akumulasiYear', compact('title', 'akumulasi', 'years', 'currentYear'));
    }
}
