<?php

namespace App\Http\Controllers;

use App\Models\Individuals;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeternakFeaturesController extends Controller
{
    public function dataMantri(){
        $title = 'Daftar Mantri';
        $mantriAkun = UserAccounts::where('roles_id', 2)->pluck('individuals_id');
        $mantri = Individuals::whereIn('id', $mantriAkun)->get();
        $mantriTerdekat = $mantri->where('alamat.kecamatan_id', Auth::user()->individual->alamat['kecamatan_id']);

        return view('peternak.layouts.datamantri', compact('title', 'mantriTerdekat', 'mantri'));
    }
}
