<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Jasa;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jasa = Jasa::latest()->paginate(5);
      
        return view('admin.jasa.jasa',compact('jasa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jasa.create');
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
            'nama_jasa' => 'required',
            'satuan_jasa' => 'required',
            'harga_jasa' => 'required',
        ]);
      
        Jasa::create($request->all());
       
        return redirect()->route('jasa.index')
                        ->with('success','Data berhasil disimpan.');    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Jasa  $jasa
     * @return \Illuminate\Http\Response
     */
    public function show(Jasa $jasa)
    {
        return view('admin.jasa.show',compact('jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Jasa  $jasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Jasa $jasa)
    {
        return view('admin.jasa.edit',compact('jasa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Jasa  $jasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jasa $jasa)
    {
        $request->validate([
            'nama_jasa' => 'required',
            'satuan_jasa' => 'required',
            'harga_jasa' => 'required',        ]);
      
        $jasa->update($request->all());
      
        return redirect()->route('jasa.index')
                        ->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Jasa  $jasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jasa $jasa)
    {
        $jasa->delete();
       
        return redirect()->route('jasa.index')
                        ->with('success','Data berhasil dihapus');      
    }
}
