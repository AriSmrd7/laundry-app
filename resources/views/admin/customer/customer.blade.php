@extends('layouts.master')
@section('title', 'Laundry - Data Pelanggan')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Pelanggan</h4>
                    <p class="card-description text-muted">List data pelanggan laundry.</p>
                    <div class="text-right mb-2">
                      <a href="{{route('customer.create')}}" class="btn btn-success">Tambah Baru</a>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="table-info">
                            <th width="1%"> No </th>
                            <th> Nama</th>
                            <th> Telepon </th>
                            <th> Alamat </th>
                            <th width="10%"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($customer as $row)
                          <tr>
                            <td>{{ ++$i }}</td>
                            <td> {{ $row->nama }} </td>
                            <td> {{ $row->telepon }} </td>
                            <td> {{ $row->alamat }} </td>
                            <td>  
                            <form action="{{ route('customer.destroy',$row->id_pelanggan) }}" method="POST">
                               <a class="btn btn-primary" href="{{ route('customer.edit',$row->id_pelanggan) }}">Ubah</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
