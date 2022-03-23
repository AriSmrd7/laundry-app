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
                            @if(!$member)
                            <input type="hidden" name="utang2" class="form-control" id="utang2" value="0" readonly/> 
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Nomor Invoice</label>
                                        <input type="text" name="no_invoice" class="form-control" id="no_invoice" value="{{$bayars->no_invoice}}" readonly/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Jumlah Tagihan</label>
                                        <input type="text" name="totalharga" class="form-control" id="totalharga2" value="{{$bayars->total_trx}}" readonly/> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Uang yang Dibayarkan</label>
                                        <input type="number" name="bayar2" class="form-control" id="bayar2" onkeypress="return onlyNumber(event, false)"  min="0"/>     
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Kembalian</label>
                                        <input type="text" name="kembalian2" class="form-control" id="kembalian2" readonly/>
                                        <input type="hidden" name="id_pelanggan" class="form-control" value="{{$bayars->id_pelanggan}}"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('transaksi.invoice',$bayars->no_invoice) }}" class="btn btn-lg btn-dark">KEMBALI</a>
                                <button type="submit" class="btn btn-lg btn-primary" id="btnBayar2">BAYAR</button>
                            </div>
                            @else
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Nomor Invoice</label>
                                        <input type="text" name="no_invoice" class="form-control" id="no_invoice" value="{{$bayars->no_invoice}}" readonly/>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Jumlah Tagihan</label>
                                        <input type="text" name="totalharga" class="form-control" id="totalharga" value="{{$bayars->total_trx}}" readonly/> 
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Sudah Dibayar</label>
                                        <input type="text" name="lunas" class="form-control" id="lunas" value="{{$bayars->bayar}}" readonly/> 
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Sisa Utang</label>
                                        <input type="text" name="utang" class="form-control" id="utang" value="{{$bayars->utang}}" readonly/> 
                                        <input type="hidden" name="utanglunas" id="utanglunas" value="0"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Uang yang Dibayarkan</label>
                                        <input type="number" name="bayar" class="form-control" id="bayar" onkeypress="return onlyNumber(event, false)"  min="0"/>     
                                    </div>
                                    <div class="col-md-4">
                                        <label for="satuan" class="col-form-label text-primary">Kembalian</label>
                                        <input type="text" name="kembalian" class="form-control" id="kembalian" readonly/>
                                        <input type="hidden" name="id_pelanggan" class="form-control" value="{{$bayars->id_pelanggan}}"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('transaksi.invoice',$bayars->no_invoice) }}" class="btn btn-lg btn-dark">KEMBALI</a>
                                <button type="submit" class="btn btn-lg btn-primary" id="btnBayar">BAYAR</button>
                            </div>
                            @endif

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
    $(document).ready(function(){

        if($('#utang').val() !== 0 || $('utang').val() !== ''){
            var bayar = $("#bayar");
            $('#btnBayar').prop('disabled', true);
            bayar.on('change keyup', function() {            
                if(bayar.val() < 0 || bayar.val() !== ''){
                    var kembalian = isNaN(parseFloat(bayar.val() - $("#utang").val())) ? 0 :(bayar.val() - $("#utang").val())
                    $("#kembalian").val(kembalian);
                    $('#btnBayar').prop('disabled', false);
                    if (parseFloat(bayar.val()) < parseFloat($("#utang").val())){
                        $('#btnBayar').prop('disabled', true);
                    }
                }
            });
        }


        
        if($('#utang2').val() == 0 || $('utang2').val() == ''){
            var bayar = $("#bayar2");
            $('#btnBayar2').prop('disabled', true);
            bayar.on('change keyup', function() {            
                if(bayar.val() < 0 || bayar.val() !== ''){
                    var kembalian = isNaN(parseFloat(bayar.val() - $("#totalharga2").val())) ? 0 :(bayar.val() - $("#totalharga2").val())
                    $("#kembalian2").val(kembalian);
                    $('#btnBayar2').prop('disabled', false);
                    if (parseFloat(bayar.val()) < parseFloat($("#totalharga2").val())){
                        $('#btnBayar2').prop('disabled', true);
                    }
                }
            });
        }

        
    });
</script>
@endpush