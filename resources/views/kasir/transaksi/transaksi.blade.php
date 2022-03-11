@extends('layouts.master')
@section('title', 'Laundry - List Pesanani')
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
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-info">
                          <th width="1%"> No </th>
                          <th> No. Invoice </th>
                          <th> Tanggal Masuk </th>
                          <th> Harga </th>
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
                          <td> {{ $row->tgl_masuk }} </td>
                          <td> {{ $row->total_trx }} </td>
                          <td> {{ $row->bayar }} </td>
                          <td> {{ $row->status }} </td>
                          <td> {{ $row->status_cucian }} </td>
                          <td>
                            <a class="btn btn-xs btn-success" href="">Detail</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                    <div class="row text-center">
                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
