@extends('layouts.master')
@section('title', 'Laundry - Data Petugas')
@section('content')
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Data Petugas</h4>
                    <p class="card-description text-muted">List data kasir yang bertugas di laundry.</p>
                    <table class="table table-bordered">
                      <thead>
                        <tr class="table-info">
                          <th width="1%"> No </th>
                          <th> Nama Kasir </th>
                          <th> Email </th>
                          <th> No. Telepon </th>
                          <th> Action </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td> 1 </td>
                          <td> Molto </td>
                          <td> Molto </td>
                          <td> Molto </td>
                          <td>  </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
@endsection
