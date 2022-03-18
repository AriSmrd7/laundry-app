@extends('layouts.master')
@section('title', 'Laundry - Data Pewangi')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Pewangi</h4>
                    <p class="card-description text-muted">Admin dapat mengelola data pewangi yang digunakan pada laundry.</p>
                    <div class="text-right mb-2">
                      <a href="{{route('pewangi.create')}}" class="btn btn-success">Tambah Baru</a>
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
                          <th> Nama Pewangi </th>
                          <th width="10%" class=" text-center"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($pewangi as $row)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td> {{ $row->nama_pewangi }} </td>
                          <td>  
                          <form action="{{ route('pewangi.destroy',$row->id_pewangi) }}" method="POST">
                              <a class="btn btn-primary" href="{{ route('pewangi.edit',$row->id_pewangi) }}">Ubah</a>
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
                    <div class="row text-center">
                        {!! $pewangi->links() !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
