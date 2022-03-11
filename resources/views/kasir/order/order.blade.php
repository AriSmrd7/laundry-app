@extends('layouts.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Order Pemesanan')
@section('content')
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Buat Order Baru</h4>
                    <p class="card-description text-muted">Input order baru.</p>                    
                    <form action="{{route('insert_order')}}" method="POST">
                    @csrf
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="id_jasa" class="col-form-label text-primary">Paket Cucian</label>
                              <select name="id_jasa" class="form-control js-example-basic-single" id="id_jasa" required>
                              <option><i>---Pilih Paket---</i></option>
                                @foreach($jasa as $jasas)
                                <option value="{{$jasas->id_jasa}}" data-satuan="{{$jasas->satuan_jasa}}" data-harga="{{$jasas->harga_jasa}}">{{$jasas->nama_jasa}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="jumlah" class="col-form-label text-primary">Jumlah</label>
                              <input type="text" name="jumlah" maxlength="3" onkeypress="return onlyNumber(event, false)" class="form-control" id="jumlah" placeholder="0" required />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="satuan" class="col-form-label text-primary">Satuan</label>
                              <input type="text" name="satuan" class="form-control" id="satuan" readonly />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="harga" class="col-form-label text-primary">Harga Paket</label>
                              <input type="text" name="harga" class="form-control" id="harga" readonly />
                              <input type="hidden" name="no_invoice" class="form-control" id="no_invoice" value="{{$noinvoice}}"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="subtotal" class="col-form-label text-primary">Subtotal</label>
                              <input type="text" name="subtotal" class="form-control" id="subtotal" readonly />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="subtotal" class="col-form-label text-primary">+</label>
                              <button class="text-light form-control btn btn-primary" id="add">Tambah</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <form action="{{route('create_invoice')}}" method="POST">
                    @csrf
                    <h4 class="text-primary">Keranjang Order</h4>
                    <p class="card-description text-muted">Detai order cucian.</p>                    
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>NOMOR INVOICE :</th>
                            <th class="text-left text-primary">
                              {{$noinvoice}}
                             <input type="hidden" value="{{$noinvoice}}" name="no_invoice" class="form-control" readonly/>
                            </th>
                            <th colspan="4">
                              &nbsp;
                            </th>
                          </tr>
                          <tr class="table-info">
                            <th>Paket Cucian</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga Paket</th>
                            <th>Subtotal</th>
                            <th width="5%">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($ordertemp as $orders)
                          <tr>
                            <td>{{$orders->nama_jasa}}</td>
                            <td>{{$orders->jumlah}}</td>
                            <td>{{$orders->satuan}}</td>
                            <td>{{$orders->harga}}</td>
                            <td>{{$orders->subtotal}}</td>
                            <td><a href="{{ route('delete_order',$orders->id_temp) }}" class="btn btn-sm btn-danger">X</a></td>
                          </tr>
                        @endforeach
                          <tr class="table-primary">
                            <td colspan="4" class="text-right"><strong>Total Harga</strong></td>
                            <td colspan="2"><strong class="text-primary">
                              @foreach ($ordertotal as $total)
                              @endforeach
                              <input type="text" value="{{$total->totalharga}}" name="total_harga" class="form-control" readonly/> 
                              <input type="hidden" value="{{$total->totalpaket}}" name="jml_paket"/> 
                            </strong></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                      <div class="row mt-4">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="pewangi" class="col-form-label text-primary">Pewangi</label>
                              <select name="id_pewangi" class="form-control js-example-basic-single" required>
                                <option><i>---Pilih Pewangi---</i></option>
                                @foreach($pewangi as $pewangis)
                                <option value="{{$pewangis->id_pewangi}}">{{$pewangis->nama_pewangi}}</option>
                                @endforeach
                                </select>                           
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_masuk" class="col-form-label text-primary">Tanggal Order</label>
                              <input type="date" name="tgl_masuk" class="form-control"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_selesai" class="col-form-label text-primary">Estimasi Selesai</label>
                              <input type="date" name="tgl_selesai" class="form-control"/>
                            </div>
                          </div>
                        </div>
                      </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="id_pelanggan" class="col-form-label text-primary">Nama Pelanggan</label>
                                <select name="id_pelanggan" class="form-control js-example-basic-single" id="id_pelanggan" required>
                                <option><i>---Pilih Pelanggan---</i></option>
                                @foreach($pelanggan as $pelanggans)
                                <option value="{{$pelanggans->id_pelanggan}}" data-telepon="{{$pelanggans->telepon}}" data-alamat="{{$pelanggans->alamat}}">{{$pelanggans->nama}}</option>
                                @endforeach
                                </select>                        
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="telepon" class="col-form-label text-primary">Nomor Hp</label>
                                <input type="text" name="telepon" id="telepon" class="form-control" readonly/>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="alamat" class="col-form-label text-primary">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <button type="submit" class="btn btn-block btn-lg btn-success">SELESAIKAN ORDER</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });

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
  $('#id_jasa').on('change',function(){
    var satuan = $(this).children('option:selected').data('satuan');
    var harga = $(this).children('option:selected').data('harga');
    $('#satuan').val(satuan);
    $('#harga').val(harga);

    $('#jumlah').on('keyup', function() {
      var jumlah = $('#jumlah').val();
      var totals = harga * jumlah;
      $('#subtotal').val(totals);    
    });
  });

</script>

<script>
  $('#id_pelanggan').on('change',function(){
    var telepon = $(this).children('option:selected').data('telepon');
    var alamat = $(this).children('option:selected').data('alamat');
    $('#telepon').val(telepon);
    $('#alamat').val(alamat);
  });
</script>
@endpush