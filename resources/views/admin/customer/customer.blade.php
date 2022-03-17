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
                      <table class="table table-bordered" id="tableCust">
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
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function() {
          $('#tableCust').DataTable({
              processing: true,
              serverSide: true,
              paging: true,
              info: false,
              ordering: false,
              searching: true,
              stateSave: true,
              destroy: true,
              lengthChange: false,
              filter: true,
              autoWidth: false, 
              ajax: "/admin/customer",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  {data: 'nama', name: 'nama'},
                  {data: 'telepon', name: 'telepon'},
                  {data: 'alamat', name: 'alamat'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
     });
</script>
@endpush
