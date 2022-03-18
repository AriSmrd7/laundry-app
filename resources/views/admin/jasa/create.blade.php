@extends('layouts.master')
@section('title', 'Laundry - Tambah Data Paket')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Tambah Data Paket</h4>
                        <p class="card-description text-small text-muted">Isi pada form di bawah ini untuk menambahkan data .</p>
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
                        <form class="forms-sample" method="POST" action="{{route('jasa.store')}}">
                        @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nama Paket</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nama_jasa" placeholder="Masukkan nama jasa">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail2">Jenis Satuan</label>
                            <select class="form-control" id="exampleInputEmail2" name="satuan_jasa">
                            <option>---Pilih---</option>
                            <option value='Kg'>Kg</option>
                            <option value='Pcs'>Pcs</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail3">Harga per Satuan</label>
                            <input type="text" class="form-control" id="exampleInputEmail3" name="harga_jasa" placeholder="Contoh : 15000">
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
