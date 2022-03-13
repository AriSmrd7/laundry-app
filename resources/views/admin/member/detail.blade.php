@extends('layouts.master')
@push('style')
<style type="text/css">
  table.invFormat tr td { 
    font-size: smaller; 
  }
  table.detailFormat tr td { 
    font-size: smaller; 
  }
  table.invFormat{
    width: 40%;
  }
  table.invFormat td.titles{
    width: 20%;
    font-weight: bold;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Detail Member')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    @foreach($membersInfo as $rowInfo)
                    @endforeach
                    <h4 class="text-primary">Detail Member</h4>
                      <div class="row">
                        <div class="col-md-10">
                        <p class="card-description text-small text-muted">Informasi detai member dengan ID : {{$rowInfo->id}} .</p>
                        </div>
                        <div clas="col-md-2 mt-2 mb-2">
                            <a href="{{ route('members.delmember',$rowInfo->id) }}" onclick="return confirm('Yakin akan menghapus seluruh data member ini dari database?')" class="btn btn-md btn-outline-danger">
                              HAPUS MEMBER
                            </a>
                        </div>
                      </div>
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>
                              <strong>{{$rowInfo->nama}}</strong>
                              {{ $message }}<a href="{{route('members.index')}}"><strong>Klik disini</strong></a></p>
                        </div>
                        @endif
                        @if ($message = Session::get('info'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <table class="table table-bordered invFormat">
                            <tr>
                              <td class="titles">ID Member</td>
                              <td>{{$rowInfo->id}}</td>
                            </tr>
                            <tr>
                              <td class="titles">Nama Lengkap</td>
                              <td>{{$rowInfo->nama}}</td>
                            </tr>
                            <tr>
                              <td class="titles">Paket Aktif</td>
                              <td>{{$rowInfo->total_paket}}</td>
                            </tr>
                            <tr>
                              <td class="titles">Total Saldo</td>
                              <td>{{$rowInfo->total_saldo}}</td>
                            </tr>
                            <tr>
                              <td class="titles">Jumlah</td>
                              <td>{{$rowInfo->total_kg}} Kg</td>
                            </tr>
                        </table>

                        <table class="table table-bordered mt-3 detailFormat">
                          <thead>
                            <tr class="table-info">
                              <th width="2%">#</th>
                              <th>Nama Paket</th>
                              <th>Harga/Kg</th>
                              <th>Jumlah</th>
                              <th>Total</th>
                              <th width="5%">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          @if($membersDetail->isEmpty())
                          <tr class="table-danger">
                            <td colspan="7" class="text-center">Maaf member ini belum berlangganan paket!</td>
                          </tr>
                          @else
                          @php $i = 0 @endphp
                          @foreach($membersDetail as $detail)
                            @php $i++ @endphp
                            <tr>
                              <td>{{$i}}</td>
                              <td>{{$detail->nama_jasa}}</td>
                              <td>{{$detail->harga_jasa}}</td>
                              <td>{{$detail->subtotal_kg}}</td>
                              <td>{{$detail->subtotal_saldo}}</td>
                              <td><a onclick="return confirm('Yakin akan menghapus paket dari member ini?')" href="{{ route('members.delete',$detail->id) }}" class="btn btn-danger btn-xs">X</a></td>
                            </tr>
                          @endforeach
                          @endif
                          </tbody>
                        </table>
                  </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    @foreach($membersInfo as $rowsId)
                    @endforeach
                    <h4 class="text-primary">Tambah Paket Baru</h4>
                      <form action="{{route('members.update',$rowsId->id)}}" method="POST">
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
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="jumlah" class="col-form-label text-primary">Jumlah (Kg)</label>
                                <input type="text" name="jumlah" maxlength="3" onkeypress="return onlyNumber(event, false)" class="form-control" id="jumlah" placeholder="0" required />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="harga" class="col-form-label text-primary">Harga/Kg</label>
                                <input type="text" name="harga" class="form-control" id="harga" readonly />
                                <input type="hidden" name="id_member" value="{{$rowsId->id}}" />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="subtotal" class="col-form-label text-primary">Total Bayar</label>
                                <input type="text" name="subtotal" class="form-control" id="subtotal" readonly />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="subtotal" class="col-form-label text-primary">+</label>
                                <button class="text-light form-control btn btn-info" id="add"><b>BELI PAKET</b></button>
                              </div>
                            </div>
                          </div>
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