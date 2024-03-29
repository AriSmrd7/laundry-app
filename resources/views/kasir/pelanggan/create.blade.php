@extends('layouts.master')
@section('title', 'Laundry - Tambah Data Pelanggan')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Tambah Data Pelanggan</h4>
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
                        <form class="forms-sample" method="POST" action="{{route('pelanggan.store')}}">
                        @csrf
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nama" placeholder="Masukkan nama pelanggan" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail2">Nomor Hp</label>
                            <input type="text" class="form-control" id="exampleInputEmail2" name="telepon" maxlength="13" placeholder="Contoh : 085863122231" required>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail3">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" placeholder="Alamat pelanggan" required></textarea>
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
