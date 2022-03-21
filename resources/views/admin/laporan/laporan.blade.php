@extends('layouts.master')
@section('title', 'Laundry - Laporan Penjualan Sukses')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Laporan Keuangan Laundry</h4>
                    <p class="card-description text-muted">Data dibawah merupakan seluruh transaksi yang berhasil dan sudah selesai..</p>

                    <div class="container">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                              <table class="table table-bordered invFormat" id="tableLap">
                                <thead class="text-center">
                                  <tr class="table-info" style="font-weight: bold;">
                                    <td widtr="1%"> No </td>
                                    <td> No. Invoice </td>
                                    <td> Nama </td>
                                    <td> Tagihan </td>
                                    <td> Bayar </td>
                                    <td> Kembalian </td>
                                    <td> Jam Masuk </td>
                                    <td> Tgl Masuk </td>
                                    <td> Jam Selesai </td>
                                    <td> Tgl Selesai </td>
                                    <td> Waktu Pembayaran </td>
                                    <td> Kasir </td>
                                  </tr>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr class="table-light text-info">
                                        <th colspan="2" style="text-align:right">Total Keseluruhan :</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                              </table>
                          </div>
                        </div>
                      </div>
                    </div>





                  </div>
                </div>
              </div>
            </div>
@endsection
@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function() {
          $('#tableLap').DataTable({
              processing: true,
              serverSide: true,
              lengthMenu: [ [ 15, 30, 50, -1 ], [ 15, 30, 50, "All" ] ],
              stateSave: true,
              paging: true,
              language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
              },
              ajax: "/admin/laporan",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  {data: 'no_invoice', name: 'no_invoice'},
                  {data: 'nama', name: 'nama'},
                  {data: 'total_trx', name: 'total_trx'},
                  {data: 'bayar', name: 'bayar'},
                  {data: 'kembalian', name: 'kembalian'},
                  {data: 'jam_masuk', name: 'jam_masuk'},
                  {data: 'tgl_masuk', name: 'tgl_masuk'},
                  {data: 'jam_selesai', name: 'jam_selesai'},
                  {data: 'tgl_selesai', name: 'tgl_selesai'},
                  {data: 'created_at', name: 'created_at'},
                  {data: 'name', name: 'name'},
              ],
              'footerCallback': function ( row, data, start, end, display ) {
                  var api = this.api();
      
                  // Remove the formatting to get integer data for summation
                  var intVal = function ( i ) {
                      return typeof i === 'string' ?
                          i.replace(/[\$,]/g, '')*1 :
                          typeof i === 'number' ?
                              i : 0;
                  };
      
                  total = api
                      .column( 3 )
                      .data()
                      .reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0 );

                      totalBayar = api
                      .column( 4 )
                      .data()
                      .reduce( function (c, d) {
                          return intVal(c) + intVal(d);
                      }, 0 );

                  totalKbl = api
                      .column( 5 )
                      .data()
                      .reduce( function (c, d) {
                          return intVal(c) + intVal(d);
                      }, 0 );
      
                  // Update footer
                  $( api.column( 3 ).footer() ).html(
                      'Rp.'+total
                  );
                  $( api.column( 4 ).footer() ).html(
                      'Rp.'+totalBayar
                  );
                  $( api.column( 5 ).footer() ).html(
                      'Rp.'+totalKbl
                  );
              }
          });
     });
</script>
@endpush