<?php

namespace App\Http\Controllers;

use App\Models\Individuals;
use App\Models\UserAccounts;
use Illuminate\Http\Request;

class DashboardDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dinas.layouts.dashboard', [
            $role =  UserAccounts::where('roles_id', 2)->pluck('individuals_id'),
            $mantri = Individuals::whereIn('id', $role)->get(),
            'mantri' => $mantri
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