@extends('layouts.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Pembayaran')
@section('content')
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Pembayaran</h4>
                    <p class="card-description text-muted">Halaman ini digunakan untuk konfirmasi pembayaran.</p>  
                    @foreach($bayar as $bayars)
                    @endforeach                  
                        <form method="POST" action="{{ route('transaksi.updatebayar',$bayars->id_transaksi) }}">
                            @csrf
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Nomor Invoice</label>
                                        <input type="text" name="no_invoice" class="form-control" id="no_invoice" value="{{$bayars->no_invoice}}" readonly/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Jumlah yang Harus Dibayar</label>
                                        <input type="text" name="totalharga" class="form-control" id="totalharga" value="{{$bayars->total_trx}}" readonly/> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Uang yang Dibayarkan</label>
                                        <input type="text" name="bayar" class="form-control" id="bayar" onkeypress="return onlyNumber(event, false)"/>     
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Kembalian</label>
                                        <input type="text" name="kembalian" class="form-control" id="kembalian" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('transaksi.invoice',$bayars->no_invoice) }}" class="btn btn-lg btn-dark">KEMBALI</a>
                                <button type="submit" class="btn btn-lg btn-primary">BAYAR</button>
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