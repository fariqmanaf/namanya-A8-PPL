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
    
        $latestData = StokSb::selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::selectRaw('jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
            ->where('periode', $latestPeriod)
            ->groupBy('kecamatan_id', 'jenis_semen_id', 'jumlah')->get();

        return view('dinas.layouts.main', [
            'title' => 'Dashboard',
            'kecamatan' => Kecamatan::all(),
            'jenis_semen' => JenisSemen::all(),
            'data' => $latestData,
            'subdata' => $subdata,
        ]);
    }

    public function riwayat(){

        $latestData = StokSb::selectRaw('kecamatan_id, periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
        ->groupBy('kecamatan_id', 'periode')->get();

        $subdata = StokSb::selectRaw('periode, jenis_semen_id, kecamatan_id, jumlah, SUM(jumlah - used) AS sisa_stok')
        ->groupBy('periode', 'kecamatan_id', 'jenis_semen_id', 'jumlah')->get();
        
        $superdata = StokSb::selectRaw('periode, SUM(jumlah) AS total_stok, SUM(jumlah - used) AS sisa_stok')
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
    
        $total_stok = $validatedData['total_stok'];
        $Simental = $validatedData['Simental'];
        $PO = $validatedData['PO'];
        $Brahma = $validatedData['Brahma'];
        $Limosin = $validatedData['Limosin'];
    
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

        foreach ($jenis as $x => $jenisStok) {
            foreach ($kecamatan as $i => $kec) {
                $persentase = $percentage[$i];
                $jumlah = $jenisStok * $persentase;
                StokSb::create([
                    'periode' => date('Y-m-d'),
                    'kecamatan_id' => $kec,
                    'jenis_semen_id' => $jenisSemen[$x],
                    'jumlah' => $jumlah,
                    'used' => 0,
                ]);
            }
        }

        session()->forget('stok');
        return redirect('/dashboard')->with('success', 'Stok berhasil ditambahkan');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
