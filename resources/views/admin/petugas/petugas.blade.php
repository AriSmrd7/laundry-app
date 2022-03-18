@extends('layouts.master')
@section('title', 'Laundry - Data Kasir')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Kasir</h4>
                    <p class="card-description text-muted">List data kasir yang bertugas di laundry.</p>
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-info">
                          <th width="1%"> No </th>
                          <th> Nama Kasir </th>
                          <th> Email </th>
                          <th width="15%"> Transaksi </th>
                          <th width="15%"> Total Orderan </th>
                          <th width="15%"> Pembayaran </th>
                          <th width="15%"> Kembalian </th>
                          <th width="15%"> Pendapatan Bersih </th>
                          <!--th width="10%"> Action </th-->
                        </tr>
                      </thead>
                      @foreach ($petugas as $row)
                      <tbody>
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td> {{ $row->name }} </td>
                          <td> {{ $row->email }} </td>
                          <td class="text-center"> {{ $row->total_trx }} </td>
                          <td class="text-center"> @rupiah($row->total_order) </td>
                          <td class="text-center"> @rupiah($row->pemasukan)</td>
                          <td class="text-center"> @rupiah($row->pengeluaran)</td>
                          <td class="text-center"> @rupiah($row->pendapatan)</td>
                          <!--td>
                          <form action="{{ route('petugas.destroy',$row->id) }}" method="POST">
                              <a class="btn btn-primary" href="{{ route('petugas.edit',$row->id) }}">Ubah</a>
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Hapus</button>
                          </form>
                          </td-->
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
@endsection
