@extends('layouts.master')
@section('title', 'Laundry - Transaksi Order')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">List Pesanan</h4>
                    <p class="card-description text-muted">Data pemesanan laundry.</p>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <a href="{{route('transaksi.index')}}" class="btn btn-outline-success" style="float: left;">REFRESH</a>
                    <div class="mb-2" style="float:right;">
                        <form action="{{route('transaksi.search')}}" method="GET">
                          <div class="input-group input-group-sm mb-3">
                            <input type="search" name="cari" class="form-control" placeholder="Cari . . ." value="{{ old('cari') }}" required aria-required="Isi dulu datanya">
                            <div class="input-group-append">
                              <input type="submit" class="btn btn-sm btn-primary" value="CARI">
                            </div>
                          </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-info">
                          <th width="1%"> No </th>
                          <th> No. Invoice </th>
                          <th> Nama </th>
                          <th> Tanggal Masuk </th>
                          <th> Tagihan </th>
                          <th> Total Bayar </th>
                          <th> Status </th>
                          <th> Cucian </th>
                          <th width="10%" class=" text-center"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($transaksi as $row)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td> {{ $row->no_invoice }} </td>
                          <td> {{ $row->nama }} </td>
                          <td> {{ $row->tgl_masuk }} </td>
                          <td> {{ $row->total_trx }} </td>
                          <td> {{ $row->bayar }} </td>
                          <td> {{ $row->status }} </td>
                          <td> {{ $row->status_cucian }} </td>
                          <td>
                            <a class="btn btn-xs btn-success" href="transaksi/invoice/{{$row->no_invoice}}">Detail</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                      <div class="col-md-12">
                        <div class="row text-center">
                          {{$transaksi->links("pagination::bootstrap-5")}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
