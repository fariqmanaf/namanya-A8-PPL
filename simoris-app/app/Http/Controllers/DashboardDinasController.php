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
            $title = 'Dashboard',
            'title' => $title,
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
    public function create()
    {
        //
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
