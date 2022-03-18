@extends('layouts.master')
@section('title', 'Laundry - Data Kasir')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Kasir</h4>
                    <p class="card-description text-muted">List data kasir yang bertugas di laundry.</p>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-info text-center">
                          <th width="1%"> No </th>
                          <th> Nama Kasir </th>
                          <th> Email </th>
                          <th width="15%"> Transaksi </th>
                          <th width="15%"> Total Orderan </th>
                          <th width="15%"> Uang Masuk </th>
                          <th width="15%"> Uang Keluar </th>
                          <th width="5%"> Status </th>
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
                          @if($row->pemasukan - $row->pengeluaran < $row->total_order)
                          <td class="text-center"><label class="badge badge-danger">Minus</label></td>
                          @else
                          <td class="text-center"><label class="badge badge-primary">Sukses</label></td>
                          @endif
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
            </div>
@endsection
