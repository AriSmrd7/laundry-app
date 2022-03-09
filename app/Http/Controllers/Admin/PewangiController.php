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
        $pewangi = Pewangi::latest()->paginate(5);
      
        return view('admin.pewangi.pewangi',compact('pewangi'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pewangi.create');
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
            'nama_pewangi' => 'required',
        ]);
      
        Pewangi::create($request->all());
       
        return redirect()->route('pewangi.index')
                        ->with('success','Data berhasil disimpan.');    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function show(Pewangi $pewangi)
    {
        return view('admin.pewangi.show',compact('pewangi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function edit(Pewangi $pewangi)
    {
        return view('admin.pewangi.edit',compact('pewangi'));
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
        $request->validate([
            'nama_pewangi' => 'required',
        ]);
      
        $pewangi->update($request->all());
      
        return redirect()->route('pewangi.index')
                        ->with('success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Pewangi  $pewangi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pewangi $pewangi)
    {
        $pewangi->delete();
       
        return redirect()->route('pewangi.index')
                        ->with('success','Data berhasil dihapus');    
    }
}
