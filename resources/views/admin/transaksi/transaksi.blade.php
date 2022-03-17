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
                    <div class="table-responsive">
                    <table class="table table-bordered" id="tableTrx">
                      <thead>
                        <tr class="table-info">
                          <th width="1%"> No </th>
                          <th> No. Invoice </th>
                          <th> Tgl Masuk </th>
                          <th> Total Harga </th>
                          <th> Status </th>
                          <th> Cucian </th>
                          <th> Kasir </th>
                          <th width="10%" class=" text-center"> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    </div>
                    <div class="row text-center">
                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function() {
          $('#tableTrx').DataTable({
              processing: true,
              serverSide: true,
              paging: true,
              info: true,
              ordering: false,
              searching: true,
              stateSave: true,
              destroy: true,
              lengthChange: false,
              filter: true,
              autoWidth: true, 
              language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
              },
              ajax: "/admin/order-transaksi",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  {data: 'no_invoice', name: 'no_invoice'},
                  {data: 'tgl_masuk', name: 'tgl_masuk'},
                  {data: 'total_trx', name: 'total_trx'},
                  {data: 'status', name: 'status'},
                  {data: 'status_cucian', name: 'status_cucian'},
                  {data: 'name', name: 'name'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
     });
</script>
@endpush