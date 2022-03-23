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
  p{
    font-size: 12px;
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
                      <h4 class="text-center font-weight-bold mb-0">Istana Laundry</h4>
                      <p class="text-center font-weight-bold mb-0">The Solution to Wash</p>
                      <p class="text-center text-muted"><small class="font-weight-bold">Call (085270902355) | WhatsApp (081260988952)</small></p>
                      @foreach($check as $checks)
                      @endforeach
                        <div class="row pb-2 p-2">
                            <div class="col-md-6">
                            <p class="mb-0"><strong>No. Invoice</strong> : {{$checks->no_invoice}}</p>
                            <p class="mb-0"><strong>Nama</strong> : {{$checks->nama}}</p>				
                            <p class="mb-0"><strong>No. HP</strong> : {{$checks->telepon}}</p>						 
                            <p><strong>Alamat</strong> : {{$checks->alamat}}</p>						 
                            </div>

                            <div class="col-md-6 text-right">
                            <p class="mb-0"><strong>Tanggal Terima</strong> : {{$checks->tgl_masuk}} - {{$checks->jam_masuk}} WIB</p>
                            <p class="mb-0"><strong>Tanggal Selesai</strong> : {{$checks->tgl_selesai}} - {{$checks->jam_selesai}} WIB</p>
                            <p class="mb-0"><strong>Pewangi</strong> : {{$checks->nama_pewangi}}</p>
                            <p><strong>Nama Kasir</strong> : {{$checks->name}}</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-bordered mb-0">
                            <thead>
                              <tr>
                                <th class="text-uppercase small font-weight-bold">Nama Paket</th>
                                <th class="text-uppercase small font-weight-bold">Qty</th>
                                <th class="text-uppercase small font-weight-bold">Harga/Kg</th>
                                <th class="text-uppercase small font-weight-bold">Subtotal</th>
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
                            </tbody>
                            <tbody class="font-weight-bold small">
                            <tr class="table-info">
                              <td colspan="3">TOTAL TAGIHAN</td>
                              <td>@rupiah($checks->total_harga)</td>
                            </tr>
                            <tr>
                              <td>Status Cucian</td>
                              <td colspan="3" class="text-left text-muted">{{$checks->status_cucian}}</td>
                            </tr>
                            <tr>
                              <td>Status Pembayaran</td>
                              <td colspan="3" class="text-left text-muted">{{$checks->status}}</td>
                            </tr>
                            @if($checks->status == 'LUNAS')
                            <tr>
                              <td>Jumlah Pembayaran</td>
                              <td colspan="3" class="text-left text-muted">@rupiah($checks->bayar)</td>
                            </tr>
                            <tr>
                              <td>Kembalian</td>
                              <td colspan="3" class="text-left text-muted">@rupiah($checks->kembalian)</td>
                            </tr>
                            @else
                            <tr>
                              <td>Jumlah Pembayaran</td>
                              <td colspan="3" class="text-left text-muted">@rupiah($checks->bayar)</td>
                            </tr>
                            <tr>
                              <td>Utang</td>
                              <td colspan="3" class="text-left text-muted">@rupiah($checks->utang)</td>
                            </tr>
                            <tr>
                              <td>Kembalian</td>
                              <td colspan="3" class="text-left text-muted">@rupiah($checks->kembalian)</td>
                            </tr>
                            @endif
                            </tbody>
                          </table>
                        </div><!--table responsive end-->
              
                        <p class="mb-0 mt-1">* Pengambilan barang WAJIB MEMBAWA NOTA.</p>
                        <p class="mb-0">* Kerusakan/luntur karena sifat bahan-bahan adalah resiko konsumen.</p>
                        <p class="mb-0">* Kami tidak bertanggung jawab jika ada BARANG/DOKUMEN YANG IKUT TERCUCI.</p>
                        <p class="mb-0">* Barang yang tidak diambil lebih dari 30 hari, hilang/rusak bukan menjadi tanggung jawab kami.</p>
                        <p class="mb-0">* Keluhan akan pelayanan dan saran dapat Hub. 085270902355 (Khusus WhatsApp).</p>
                        <p class="mb-0">* Komplain/kehilangan barang hanya 1x24 jam. Kami tidak bertanggung jawab bila diluar waktu tersebut.</p>
                      <div class="row mt-4">
                          <div class="col-md-10">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <a href="{{route('transaksi.index')}}" class="btn btn-lg btn-light">Kembali</a>  
                                @if($checks->status_cucian === 'Selesai')
                                <button class="btn btn-lg btn-outline-info" disabled>Sudah Diambil</button> 
                                @else
                                <a href="{{ route('transaksi.status',$checks->no_invoice) }}" class="btn btn-lg btn-info">Ubah Status</a> 
                                @endif

                                @if($checks->status === 'BELUM LUNAS')                             
                                <a href="{{ route('transaksi.bayar',$checks->no_invoice) }}" class="btn btn-lg btn-primary">Pembayaran</a>                
                                @else                             
                                <button class="btn btn-lg btn-outline-warning" disabled>Pembayaran Lunas</button>                
                                @endif
                              </div>
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