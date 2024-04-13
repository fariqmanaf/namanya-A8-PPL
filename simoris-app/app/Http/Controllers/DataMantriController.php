<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Individuals;
use App\Models\Sertifikasi;
use App\Models\SuratIzin;
use App\Models\UserAccounts;
use Illuminate\Http\Request;

class DataMantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akunMantri = UserAccounts::where('roles_id', 2)->where('status', 'enable')->pluck('individuals_id')->toArray();
        $dataMantri = Individuals::whereIn('id', $akunMantri)->get();
        $alamatMantri = Alamat::whereIn('id', $dataMantri->pluck('alamats_id')->toArray())->get();
        $kabupaten = Kabupaten::whereIn('id', $alamatMantri->pluck('kabupaten_id')->toArray())->get();
        $kecamatan = Kecamatan::whereIn('id', $alamatMantri->pluck('kecamatan_id')->toArray())->get();
        $kelurahan = Kelurahan::whereIn('id', $alamatMantri->pluck('kelurahan_id')->toArray())->get();
        $sertifikasi = Sertifikasi::whereIn('individuals_id', $akunMantri)->get();
        $suratizin = SuratIzin::whereIn('individuals_id', $akunMantri)->get();

        $title = 'Data Mantri';
        return view('dinas.layouts.datamantri', compact('akunMantri', 'title', 'dataMantri', 'alamatMantri', 'kabupaten', 'kecamatan', 'kelurahan', 'sertifikasi', 'suratizin'));
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
