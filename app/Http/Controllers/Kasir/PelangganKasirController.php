<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kasir\PelangganKasir;
use Illuminate\Http\Request;

class PelangganKasirController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_KASIR');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = PelangganKasir::latest()->paginate(5);
      
        return view('kasir.pelanggan.pelanggan',compact('pelanggan'))
            ->with('i', (request()->input('page', 1) - 1) * 5);           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kasir.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);
      
        PelangganKasir::create($request->all());
       
        return redirect()->route('pelanggan.index')
                        ->with('success','Data berhasil disimpan.');                        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kasir\PelangganKasir  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(PelangganKasir $pelanggan)
    {
        return view('kasir.pelanggan.show',compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kasir\PelangganKasir  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(PelangganKasir $pelanggan)
    {
        return view('kasir.pelanggan.edit',compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kasir\PelangganKasir  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PelangganKasir $pelanggan)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',        ]);
      
        $pelanggan->update($request->all());
      
        return redirect()->route('pelanggan.index')
                        ->with('success','Data berhasil diubah');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelangganKasir $pelanggan)
    {
        $pelanggan->delete();
       
        return redirect()->route('pelanggan.index')
                        ->with('success','Data berhasil dihapus');      
    }
}
