<?php

namespace App\Http\Controllers;

use App\Models\StokSb;
use App\Models\Kecamatan;
use App\Models\JenisSemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
