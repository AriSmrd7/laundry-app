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
                    <h4 class="text-primary">Detail Orderan</h4>
                    <p class="card-description text-muted">Halaman ini digunakan untuk mengubah status invoice.</p>    
                    @foreach($check as $checks)
                    @endforeach
                    <div class="col-md-12 mb-3">
                      <div class="text-right">
                        <a href="{{route('transaksi.delete',$checks->no_invoice)}}" class="btn btn-outline-danger btn-md" onclick="return confirm('Yakin akan menghapus order ini?');">
                          HAPUS
                        </a>
                      </div>
                    </div>                
                    <div>
                      <table class="table table-bordered table100 invFormat">
                          <thead>
                            <tr>
                              <td>Nomor Invoice</td>
                              <td colspan="3" class="text-primary">{{$checks->no_invoice}}</td>
                            </tr>
                            <tr>
                              <td>Nama Pelanggan</td>
                              <td colspan="3" class="text-primary">{{$checks->nama}}</td>
                            </tr>
                            <tr>
                              <td>No. Telepon</td>
                              <td colspan="3" class="text-primary">{{$checks->telepon}}</td>
                            </tr>
                            <tr>
                              <td>Alamat</td>
                              <td colspan="3" class="text-primary">{{$checks->alamat}}</td>
                            </tr>
                            <tr>
                              <td>Tanggal Masuk</td>
                              <td colspan="3" class="text-primary">{{$checks->tgl_masuk}}</td>
                            </tr>
                            <tr>
                              <td>Estimasi Selesai</td>
                              <td colspan="3" class="text-primary">{{$checks->tgl_selesai}}</td>
                            </tr>
                            <tr>
                              <td>Pewangi</td>
                              <td colspan="3" class="text-primary">{{$checks->nama_pewangi}}</td>
                            </tr>
                            <tr>
                              <td>Jumlah Paket</td>
                              <td colspan="3" class="text-info">{{$checks->jml_paket}}</td>
                            </tr>
                            <tr>
                              <td>Nama Kasir</td>
                              <td colspan="3" class="text-info">{{$checks->name}}</td>
                            </tr>
                            <tr class="table-info">
                              <td>Nama Paket</td>
                              <td>Jumlah</td>
                              <td>Harga/Kg</th>
                              <td>Subtotal</td>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($detail as $rowDetails)
                            <tr>
                              <td>{{$rowDetails->nama_jasa}}</td>
                              <td>{{$rowDetails->jumlah}} {{$rowDetails->satuan}}</td>
                              <td>@rupiah($rowDetails->harga)</td>
                              <td>@rupiah($rowDetails->subtotal)</td>
                            </tr>
                          @endforeach
                            <tr class="table-info">
                              <td colspan="3" class="text-right">TOTAL TAGIHAN</td>
                              <td class="text-primary">@rupiah($checks->total_harga)</td>
                            </tr>
                            <tr>
                              <td>Status Cucian</td>
                              <td colspan="3" class="text-left text-primary">{{$checks->status_cucian}}</td>
                            </tr>
                            <tr>
                              <td>Status Pembayaran</td>
                              <td colspan="3" class="text-left text-primary">{{$checks->status}}</td>
                            </tr>
                            @if($checks->status == 'LUNAS')
                            <tr>
                              <td>Uang yang Dibayar</td>
                              <td colspan="3" class="text-left text-primary">@rupiah($checks->bayar)</td>
                            </tr>
                            <tr>
                              <td>Kembalian</td>
                              <td colspan="3" class="text-left text-primary">@rupiah($checks->kembalian)</td>
                            </tr>
                            @else
                            <tr>
                              <td>Uang yang Dibayar</td>
                              <td colspan="3" class="text-left text-primary">@rupiah($checks->bayar)</td>
                            </tr>
                            <tr>
                              <td>Utang</td>
                              <td colspan="3" class="text-left text-primary">@rupiah($checks->utang)</td>
                            </tr>
                            <tr>
                              <td>Kembalian</td>
                              <td colspan="3" class="text-left text-primary">@rupiah($checks->kembalian)</td>
                            </tr>
                            @endif
                          </tbody>
                      </table>
                    </div>
                      <div class="row mt-5">
                          <div class="col-md-10">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <a href="{{route('transaksi.index')}}" class="btn btn-md btn-light">Kembali</a>  
                                @if($checks->status_cucian === 'Selesai')
                                <a class="btn btn-md btn-outline-info text-info" disabled>Sudah Diambil</a> 
                                @else
                                <a href="{{ route('transaksi.status',$checks->no_invoice) }}" class="btn btn-md btn-info">Ubah Status</a> 
                                @endif

                                @if($checks->status === 'BELUM LUNAS')                             
                                <a href="{{ route('transaksi.bayar',$checks->no_invoice) }}" class="btn btn-md btn-primary">Pembayaran</a>                
                                @else                             
                                <a class="btn btn-md btn-outline-success text-success" disabled>Pembayaran Lunas</a>                
                                @endif
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