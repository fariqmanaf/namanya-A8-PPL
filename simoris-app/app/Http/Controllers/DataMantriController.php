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
use App\Models\WilayahKerja;
use Illuminate\Http\Request;

class DataMantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akunMantri = UserAccounts::where('roles_id', 2)->where('status', 'enable')->get();
        $dataMantri = Individuals::whereIn('id', $akunMantri->pluck('individuals_id'))->get();

        $title = 'Data Mantri';
        return view('dinas.layouts.datamantri', compact('title' ,'akunMantri', 'dataMantri'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function confirm()
    {
        $akunMantri = UserAccounts::where('roles_id', 2)->where('status', 'pending')->get();
        $dataMantri = Individuals::whereIn('id', $akunMantri->pluck('individuals_id'))->get();

        $title = 'Verifikasi Pengajuan';
        return view('dinas.layouts.verifikasipengajuan', compact('title' ,'akunMantri', 'dataMantri'));
    }

    public function postConfirm(Request $request)
    {
        $id = $request->id;
        $statusSertif = $request->is_accepted_sertif;
        $statusIzin = $request->is_accepted_izin;
        $statusUser = null;

        if($statusSertif == 1 && $statusIzin == 1){
            $statusUser = 'enable';
        }else{
            $statusUser = 'rejected';
        }

        Sertifikasi::where('individuals_id', $id)->update(
            ['is_accepted' => $statusSertif]
        );
        SuratIzin::where('individuals_id', $id)->update(
            ['is_accepted' => $statusIzin]
        );

        UserAccounts::where('individuals_id', $id)->update(
            ['status' => $statusUser]
        );

        return redirect('/dashboard/data-mantri/confirm')->with('success', 'Data Mantri berhasil diverifikasi');
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
