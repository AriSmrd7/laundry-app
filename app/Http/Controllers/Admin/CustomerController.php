<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('id_pelanggan','nama','telepon','alamat')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $csrf = csrf_token();
                    $btn = "<form action='/admin/customer/{$row->id_pelanggan}' method='POST'>
                    <a class='btn btn-xs btn-primary' href='/admin/customer/{$row->id_pelanggan}/edit'>Ubah</a>
                    <input type='hidden' name='_method' value='delete' />
                    <input type='hidden' name='_token' value='{$csrf}'>
                     <button type='submit' class='btn btn-xs btn-danger'>Hapus</button>
                 </form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $customer = Customer::latest()->paginate(5);
      
        return view('admin.customer.customer',compact('customer'))
            ->with('i', (request()->input('page', 1) - 1) * 5);           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
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
      
        Customer::create($request->all());
       
        return redirect()->route('customer.index')
                        ->with('success','Data berhasil disimpan.');                        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customer.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',        
        ]);
      
        $customer->update($request->all());
      
        return redirect()->route('customer.index')
                        ->with('success','Data berhasil diubah');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
       
        return redirect()->route('customer.index')
                        ->with('success','Data berhasil dihapus');      
    }
}
