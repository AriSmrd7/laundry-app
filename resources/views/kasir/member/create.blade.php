@extends('layouts.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Tambah Data Member')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Tambah Data Member</h4>
                        <p class="card-description text-small text-muted">Pilih nama pelanggan untuk ditambahkan ke member baru .</p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong>Mohon isi form dengan benar.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
   
                        <div class="col-lg-6">
                        <form class="forms-sample" method="POST" action="{{route('members-kasir.store')}}">
                        @csrf
                          <div class="col-md-3 mb-0">
                            <div class="form-group row">
                                <label for="id_pelanggan" class="col-form-label text-primary">ID Member</label>
                                <input type="text" class="form-control" value="{{$idMember}}" name="id" readonly/>                   
                            </div>
                          </div>
                          <div class="col-md-8 mb-5">
                            <div class="form-group row">
                                <label for="id_pelanggan" class="col-form-label text-primary">Nama Pelanggan</label>
                                <select name="id_pelanggan" class="form-control js-example-basic-single" id="id_pelanggan" required>
                                <option><i>---Pilih Pelanggan---</i></option>
                                @foreach($pelanggans as $pelanggan)
                                <option value="{{$pelanggan->id_pelanggan}}">{{$pelanggan->nama}}</option>
                                @endforeach
                                </select>                        
                            </div>
                          </div>
                          <a class="btn btn-light" href="{{route('members-kasir.index')}}">Cancel</a>
                          <button type="submit" class="btn btn-success mr-2">Simpan</button>
                        </form>
                        </div>
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

@endpush