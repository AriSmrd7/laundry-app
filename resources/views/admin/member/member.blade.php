@extends('layouts.master')
@section('title', 'Laundry - Data Member')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Member</h4>
                    <p class="card-description text-muted">Data pelanggan yang sudah menjadi memberi di laundry</p>
                    <div class="text-right mb-2">
                      <a href="{{route('members.create')}}" class="btn btn-success">Tambah Baru</a>
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
                          <th> Nama Pelanggan </th>
                          <th> Paket Aktif</th>
                          <th> Total Saldo</th>
                          <th> Jumlah</th>
                          <th width="10%" class=" text-center"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      @if($members->isEmpty())
                          <tr class="table-danger">
                            <td colspan="7" class="text-center">Maaf belum ada data member. Silahkan klik Tambah Baru untuk mendaftarkan member.</td>
                          </tr>
                      @else
                      @php $i = 0 @endphp
                      @foreach ($members as $row)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td> {{ $row->nama }} </td>
                          <td> {{ $row->total_paket }} </td>
                          <td> @rupiah($row->total_saldo) </td>
                          <td> {{ $row->total_kg }} Kg</td>
                          <td>  
                            <a class="btn btn-xs btn-primary" href="{{url('admin/member/detail/'.$row->id)}}">Detail & Deposit</a>
                          </td>
                        </tr>
                      @endforeach
                      @endif
                      </tbody>
                    </table>
                      <div class="col-md-12">
                        <div class="row text-center">
                          {{$members->links("pagination::bootstrap-5")}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
