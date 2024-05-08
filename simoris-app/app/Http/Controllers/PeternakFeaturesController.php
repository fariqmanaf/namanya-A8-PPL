<?php

namespace App\Http\Controllers;

use App\Models\DataSapi;
use App\Models\Individuals;
use App\Models\LaporanIb;
use App\Models\UserAccounts;
use App\Models\WilayahKerja;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Auth;

class PeternakFeaturesController extends Controller
{
    public function dataMantri(){
        $title = 'Daftar Mantri';
        $mantriAkun = UserAccounts::where('roles_id', 2)->pluck('individuals_id');
        $mantri = Individuals::whereIn('id', $mantriAkun)->get();
        $wilayahKerja = WilayahKerja::where('kecamatan_id', Auth::user()->individual->alamat->kecamatan_id)->pluck('individuals_id');
        $mantriTerdekat = Individuals::whereIn('id', $wilayahKerja)->get();

        return view('peternak.layouts.datamantri', compact('title', 'mantriTerdekat', 'mantri'));
    }

    public function laporanIB(){
        $title = 'Laporan IB';
        $dataSapi = DataSapi::where('individuals_id', Auth::user()->individual->id)->get();

        return view('peternak.layouts.laporanIB', compact('title', 'dataSapi'));
    }

    public function laporanIBDetail(DataSapi $dataSapi){
        $title = 'Detail Laporan IB';
        $laporanIB = LaporanIb::where('data_sapi_id', $dataSapi->id)->get();
        if($laporanIB->pluck('id_mantri')){
            $inseminator = Individuals::whereIn('id', $laporanIB->pluck('id_mantri'))->get();
        } else {$inseminator = null;}

        return view('peternak.layouts.laporanIBDetail', compact('title', 'laporanIB', 'inseminator'));
    }
}

// @foreach($mantriTerdekat as $mantriTerdekat)

//     <p>Nama: {{ $mantriTerdekat->name }}</p>
//     <p>Alamat: 
//       {{ $mantriTerdekat->alamat['detail'] }},
//       {{ $mantriTerdekat->alamat->kelurahan['kelurahan'] }},
//       {{ $mantriTerdekat->alamat->kecamatan['kecamatan'] }},
//       {{ $mantriTerdekat->alamat->kabupaten['kabupaten'] }}
//     </p>
//     <a id="phone-number" href="https://api.whatsapp.com/send?phone={{ $mantriTerdekat->no_telp }}" target="_blank" class="p-2 bg-blue-600 text-white font-semibold rounded-2xl">Hubungi via WhatsApp</a>

// @endforeach
