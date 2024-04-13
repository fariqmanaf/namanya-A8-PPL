<?php

namespace App\Http\Controllers;

use App\Models\StokSb;
use App\Models\Kecamatan;
use App\Models\Individuals;
use App\Models\JenisSemen;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestPeriod = StokSb::select('periode')->orderByDesc('periode')->value('periode');
        $previousPeriod = StokSb::select('periode')->groupBy('periode')->orderBydesc('periode')->take(1)->value('periode');

        $latestData = StokSb::selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::selectRaw('jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'jenis_semen_id', 'jumlah')->get();

        $riwayatStok = StokSb::selectRaw('jenis_semen_id, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $previousPeriod)
            ->groupBy('jenis_semen_id')->get();

        return view('dinas.layouts.main', [
            'title' => 'Dashboard',
            'kecamatan' => Kecamatan::all(),
            'jenis_semen' => JenisSemen::all(),
            'data' => $latestData,
            'subdata' => $subdata,
            'riwayatStok' => $riwayatStok,
            'periode' => $previousPeriod
        ]);
    }

    public function riwayat(){

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
    public function createStok(Request $request) {
        $validatedData = $request->validate([
            'total_stok' => 'required',
            'Simental' => 'required',
            'PO' => 'required',
            'Brahma' => 'required',
            'Limosin' => 'required',
        ]);
    
        $total_sisa = request('sisa-1') + request('sisa-2') + request('sisa-3') + request('sisa-4');
        $total_stok = $validatedData['total_stok'] += $total_sisa;
        $Simental = $validatedData['Simental'] += request('sisa-1');
        $PO = $validatedData['PO'] += request('sisa-2');
        $Brahma = $validatedData['Brahma'] += request('sisa-3');
        $Limosin = $validatedData['Limosin'] += request('sisa-4');
    
        $totalJenis = $Simental + $PO + $Brahma + $Limosin;
        if ($total_stok != $totalJenis) {
            return redirect('/dashboard')->withErrors('Total stok tidak sesuai dengan jumlah jenis semen');
        } else {    
            session()->put('stok.total_stok', $total_stok);
            session()->put('stok.Simental', $Simental);
            session()->put('stok.PO', $PO);
            session()->put('stok.Brahma', $Brahma);
            session()->put('stok.Limosin', $Limosin);
            
            return redirect('/dashboard/preview');
        }
    }

    public function preview(Request $request){

        $jenisSemen = JenisSemen::all()->pluck('id')->toArray();
        $kecamatan = Kecamatan::all();

        $jenis = [session()->get('stok.Simental'), session()->get('stok.PO'), session()->get('stok.Brahma'), session()->get('stok.Limosin')];
        $percentage = [0.2, 0.2, 0.3, 0.2, 0.1];

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
                    'jumlah' => $jumlah,
                    'sisa_stok' => $jumlah,
                ];
            }
            $data[] = (object)[
                'periode' => date('Y-m-d'),
                'kecamatan_id' => $kec,
                'total_stok' => $total_stok,
                'sisa_stok' => $total_stok,
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

    public function previewpost(Request $request){

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
        $percentage = [0.2, 0.2, 0.3, 0.2, 0.1];
        $kecamatan = Kecamatan::all()->pluck('id');
        $jenisSemen = JenisSemen::all()->pluck('id');
        $status = 'aktif';

        foreach ($jenis as $x => $jenisStok) {
            foreach ($kecamatan as $i => $kec) {
                $persentase = $percentage[$i];
                $jumlah = $jenisStok * $persentase;
                StokSb::create([
                    'periode' => '2024-04-23',
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
}
