@extends('layouts.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Status Cucian')
@section('content')
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Update Status Cucian</h4>
                    <p class="card-description text-muted">Halaman ini digunakan untuk konfirmasi pembayaran.</p>  
                    @foreach($status as $rows)
                    @endforeach                  
                        <form method="POST" action="{{ route('transaksi.updatestatus',$rows->no_invoice) }}">
                            @csrf
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Nomor Invoice</label>
                                        <input type="text" name="no_invoice" class="form-control" id="no_invoice" value="{{$rows->no_invoice}}" readonly/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail2" class="col-form-label text-primary">Jenis Satuan</label>
                                        <select class="form-control" id="exampleInputEmail2" name="status_cucian">
                                            <option value="Diproses" @if($rows->status_cucian == 'Diproses') ? selected : null @endif>Diproses</option>
                                            <option value="Belum Diambil" @if($rows->status_cucian == 'Belum Diambil') ? selected : null @endif>Belum Diambil</option>
                                            <option value="Selesai" @if($rows->status_cucian == 'Selesai') ? selected : null @endif>Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('transaksi.invoice',$rows->no_invoice) }}" class="btn btn-lg btn-dark">KEMBALI</a>
                                <button type="submit" class="btn btn-lg btn-primary">UBAH</button>
                            </div>
                        </form>
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
<script>
    $('#bayar').on('keyup', function() {
        var total = $('#totalharga').val();
        var bayar = $('#bayar').val();
        var kembalian = bayar - total;
        $('#kembalian').val(kembalian);    
    });
</script>
@endpush