@extends('layouts.master')
@push('style')
<style type="text/css">
  table.invFormat tr td { 
    font-size: x-small; 
    font-weight: bold;
  }
  .table100, .row, .container, .table-responsive, .table-bordered  {
    height: 100%;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Invoice')
@section('content')
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Invoice Orderan</h4>
                    <p class="card-description text-muted">Halaman ini digunakan untuk mengubah status invoice.</p>                    
                    <div>
                    @foreach($check as $checks)
                    @endforeach
                      <table class="table table-bordered table100 invFormat">
                          <thead>
                            <tr>
                              <td>Nomor Invoice</td>
                              <td colspan="4" class="text-primary">{{$checks->no_invoice}}</td>
                            </tr>
                            <tr>
                              <td>Nama Pelanggan</td>
                              <td colspan="4" class="text-primary">{{$checks->nama}}</td>
                            </tr>
                            <tr>
                              <td>No. Telepon</td>
                              <td colspan="4" class="text-primary">{{$checks->telepon}}</td>
                            </tr>
                            <tr>
                              <td>Alamat</td>
                              <td colspan="4" class="text-primary">{{$checks->alamat}}</td>
                            </tr>
                            <tr>
                              <td>Tanggal Masuk</td>
                              <td colspan="4" class="text-primary">{{$checks->tgl_masuk}}</td>
                            </tr>
                            <tr>
                              <td>Estimasi Selesai</td>
                              <td colspan="4" class="text-primary">{{$checks->tgl_selesai}}</td>
                            </tr>
                            <tr>
                              <td>Pewangi</td>
                              <td colspan="4" class="text-primary">{{$checks->nama_pewangi}}</td>
                            </tr>
                            <tr>
                              <td>Jumlah Paket</td>
                              <td colspan="4" class="text-info">{{$checks->jml_paket}}</td>
                            </tr>
                            <tr>
                              <td>Nama Kasir</td>
                              <td colspan="4" class="text-info">{{$checks->name}}</td>
                            </tr>
                            <tr class="table-info">
                              <td>Nama Paket</td>
                              <td>Jumlah</td>
                              <td>Satuan</td>
                              <td>Harga/Paket</th>
                              <td>Subtotal</td>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($detail as $rowDetails)
                            <tr>
                              <td>{{$rowDetails->nama_jasa}}</td>
                              <td>{{$rowDetails->jumlah}}</td>
                              <td>{{$rowDetails->satuan}}</td>
                              <td>{{$rowDetails->harga}}</td>
                              <td>{{$rowDetails->subtotal}}</td>
                            </tr>
                          @endforeach
                            <tr class="table-info">
                              <td colspan="4" class="text-right">TOTAL HARGA</td>
                              <td class="text-primary">{{$checks->total_harga}}</td>
                            </tr>
                            <tr>
                              <td>Status Cucian</td>
                              <td colspan="4" class="text-left text-primary">{{$checks->status_cucian}}</td>
                            </tr>
                            <tr>
                              <td>Status Pembayaran</td>
                              <td colspan="4" class="text-left text-primary">{{$checks->status}}</td>
                            </tr>
                            @if($checks->status == 'LUNAS')
                            <tr>
                              <td>Uang yang Dibayar</td>
                              <td colspan="4" class="text-left text-primary">{{$checks->bayar}}</td>
                            </tr>
                            <tr>
                              <td>Kembalian</td>
                              <td colspan="4" class="text-left text-primary">{{$checks->kembalian}}</td>
                            </tr>
                            @endif
                          </tbody>
                      </table>
                    </div>
                      <div class="row mt-5">
                          <div class="col-md-10">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <a href="{{route('order-transaksi.index')}}" class="btn btn-md btn-outline-dark">Kembali</a>  
                              </div>
                            </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
  function onlyNumber(e,decimal){
            var key;
            var keychar;
            if(window.event){
                key = window.event.keyCode;
            }else
                if(e){
                    key = e.which;
                }else return true;
                
                keychar = String.fromCharCode(key);
                if((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)){
                    return true;
                }else
                    if((("0123456789").indexOf(keychar)>-1)){
                        return true;
                    }else
                        if(decimal && (keychar ==".")){
                            return true;
                        }else return false;
	}
</script>