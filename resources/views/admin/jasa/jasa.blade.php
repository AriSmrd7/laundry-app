@extends('layouts.master')
@section('title', 'Laundry - Data Paket')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Paket Cucian</h4>
                    <p class="card-description text-muted">List data paket cucian yang ada pada laundry.</p>
                    <div class="text-right mb-2">
                      <a href="{{route('jasa.create')}}" class="btn btn-success">Tambah Baru</a>
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
                          <th> Nama Paket </th>
                          <th width="5%"> Harga </th>
                          <th width="10%" class=" text-center"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($jasa as $row)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td> {{ $row->nama_jasa }} </td>
                          <td> @rupiah($row->harga_jasa)/{{ $row->satuan_jasa }}</td>
                          <td>  
                          <form action="{{ route('jasa.destroy',$row->id_jasa) }}" method="POST">
                              <a class="btn btn-xs btn-primary" href="{{ route('jasa.edit',$row->id_jasa) }}">Ubah</a>
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
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

