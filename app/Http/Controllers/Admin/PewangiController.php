<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pewangi;
use Illuminate\Http\Request;

class PewangiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo 'pewangi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function show(Pewangi $pewangi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function edit(Pewangi $pewangi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pewangi $pewangi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pewangi $pewangi)
    {
        //
    }
}
