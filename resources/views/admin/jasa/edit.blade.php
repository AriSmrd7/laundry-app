@extends('layouts.master')
@section('title', 'Laundry - Ubah Data Paket')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Ubah Data Paket</h4>
                        <p class="card-description text-small text-muted">Update pada form di bawah ini untuk mengubah data .</p>
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
                        <form class="forms-sample" method="POST" action="{{ route('jasa.update',$jasa->id_jasa) }}">
                        @csrf
                        @method('PUT')
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nama Paket</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nama_jasa" value="{{$jasa->nama_jasa}}">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail2">Jenis Satuan</label>
                            <select class="form-control" id="exampleInputEmail2" name="satuan_jasa">
                              <option value="Kg" {{ $jasa->satuan_jasa == 'Kg' ? 'selected' : '' }}>Kg</option>
                              <option value="Pcs" {{ $jasa->satuan_jasa == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail3">Harga per Satuan</label>
                            <input type="text" class="form-control" id="harga" name="harga_jasa" value="{{$jasa->harga_jasa}}">
                          </div>
                          <button type="submit" class="btn btn-success mr-2">Simpan</button>
                          <button class="btn btn-light">Cancel</button>
                        </form>
                        </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
@push('custom-scripts')
<script type="text/javascript">
  $('#harga').on('input', function() {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
  });
</script>
@endpush
