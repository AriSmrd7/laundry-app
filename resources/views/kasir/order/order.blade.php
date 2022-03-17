@extends('layouts.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Laundry - Order Pemesanan')
@section('content')
            <div class="row">

                          
            <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <form action="{{route('create_invoice')}}" method="POST">
                    @csrf
                    <h4 class="text-primary">Buat Order</h4>
                    <p class="card-description text-muted">Buat order cucian.</p>       
                        <div class="row mt-4">
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="id_pelanggan" class="col-form-label text-primary">Nama Pelanggan</label>
                                <select name="id_pelanggan" class="form-control js-example-basic-single" id="id_pelanggan" required>
                                <option><i>---Pilih Pelanggan---</i></option>
                                @foreach($pelanggan as $pelanggans)
                                <option value="{{$pelanggans->id_pelanggan}}" data-telepon="{{$pelanggans->telepon}}" data-alamat="{{$pelanggans->alamat}}">{{$pelanggans->nama}}</option>
                                @endforeach
                                </select>                        
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="telepon" class="col-form-label text-primary">Nomor Hp</label>
                                <input type="text" name="telepon" id="telepon" class="form-control" readonly/>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="alamat" class="col-form-label text-primary">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                              </div>
                            </div>
                          </div>
                        </div>   
                        <!-- check member -->
                        <div class="row col-md-12" id="notMember" style="display: none;">
                          <div class="col-sm-12">
                            <div class="alert alert-info">
                              <strong class="text-center">Bukan member laundry</strong>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-2" id="memberInfo" style="display:flexbox">
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="id_pelanggan" class="col-form-label text-primary">ID Member</label>
                                <input type="text" name="id_member" id="id_member" class="form-control" value="" readonly/>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="id_pelanggan" class="col-form-label text-primary">Total Sisa (Kg)</label>
                                <input type="text" name="total_kg" id="sisa" class="form-control" value="" readonly/>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label for="id_pelanggan" class="col-form-label text-primary">Saldo</label>
                                <input type="text" name="total_saldo" id="saldo" class="form-control" value="" readonly/>
                              </div>
                            </div>
                          </div>
                        </div>      
                        <!-- end check member -->
                      <div class="row mt-0">
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-11">
                              <label for="pewangi" class="col-form-label text-primary">Pewangi</label>
                              <select name="id_pewangi" class="form-control js-example-basic-single" required>
                                <option value="0"><i>--Pilih--</i></option>
                                @foreach($pewangi as $pewangis)
                                <option value="{{$pewangis->id_pewangi}}">{{$pewangis->nama_pewangi}}</option>
                                @endforeach
                                </select>                           
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_masuk" class="col-form-label text-primary">Tanggal Order</label>
                              <input type="text" name="tgl_masuk" class="form-control" id="tgl_masuk" value="{{date('d/m/Y')}}" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_masuk" class="col-form-label text-primary">Jam Masuk</label>
                              <input type="text" name="jam_masuk" class="form-control" id="jam_masuk" value="{{date('H.m')}}" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_selesai" class="col-form-label text-primary">Estimasi Selesai</label>
                              <input type="date" name="tgl_selesai" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="tgl_masuk" class="col-form-label text-primary">Jam Keluar</label>
                              <input type="time" name="jam_selesai" class="form-control" id="jam_selesai" required/>
                            </div>
                          </div>
                        </div>    
                      </div>  
                      <div class="row mt-4">
                        <div class="col-md-12">
                          <div class="form-group row">
                            <div class="col-sm-2">
                              <a class="btn btn-md btn-block btn-light" id="btnReset"><strong>RESET</strong></a>
                            </div>
                            <div class="col-sm-3">
                              <a class="btn btn-lg btn-block text-light btn-primary" type="button" id="btnKonfirmasi">
                                <strong>CHECK</strong>
                              </a>
                            </div>
                            <input type="hidden" name="no_invoice" class="form-control" id="no_invoice" value="{{$noinvoice}}"/>
                            <div class="col-sm-7">
                                  <button type="submit" class="btn btn-block btn-lg btn-success" id="btn-finish">
                                    <strong>SELESAIKAN ORDER</strong>
                                  </button>
                            </div>
                      </div>  
                      <hr style="height:1px;border-width:0;color:gray;background-color:dodgerblue">
                    </form>
                </div>
              </div>

              <div class="col-12 grid-margin" id="add-order">
                <div class="card">
                  <div class="card-body">
                    <h4 class="text-primary">Tambah Ke Keranjang</h4>
                    <p class="card-description text-muted">Input order baru.</p>                    
                    <form id="addOrder">
                      @csrf
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="id_jasa" class="col-form-label text-primary">Paket Cucian</label>
                              <select name="id_jasa" class="form-control js-example-basic-single" id="id_jasa" required>
                              <option><i>---Pilih Paket---</i></option>
                                @foreach($jasa as $jasas)
                                <option value="{{$jasas->id_jasa}}" data-satuan="{{$jasas->satuan_jasa}}" data-harga="{{$jasas->harga_jasa}}" data-nama="{{$jasas->nama_jasa}}" >{{$jasas->nama_jasa}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="jumlah" class="col-form-label text-primary">Jumlah</label>
                              <input type="text" name="jumlah" maxlength="10" class="form-control" id="jumlah" placeholder="0" required />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="satuan" class="col-form-label text-primary">Satuan</label>
                              <input type="text" name="satuan" class="form-control" id="satuan" readonly />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="harga" class="col-form-label text-primary">Harga/Kg</label>
                              <input type="text" name="harga" class="form-control" id="harga" readonly />
                              <input type="hidden" name="id_pelanggan" class="form-control" id="idpel" value=""/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="subtotal" class="col-form-label text-primary">Subtotal</label>
                              <input type="text" name="subtotal" class="form-control" id="subtotal" readonly />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="subtotal" class="col-form-label text-primary">+</label>
                              <button class="text-light form-control btn btn-primary" id="submit">Tambah</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!--cart-->
              <div class="row col-md-12">
                <div class="table-responsive mt-2" id="cart_table">
                      <h4 class="text-primary">Keranjang Order</h4>
                      <p class="card-description text-muted">Detail order cucian.</p>  
                        <table class="table table-hover" id="tableCart">
                          <thead>
                            <tr>
                              <th>NOMOR INVOICE :</th>
                              <th class="text-left text-primary">
                                {{$noinvoice}}
                              <input type="hidden" value="{{$noinvoice}}" name="no_invoice" class="form-control" readonly/>
                              </th>
                              <th colspan="4">
                                &nbsp;
                              </th>
                            </tr>
                            <tr class="table-info">
                              <th>Paket Cucian</th>
                              <th>Jumlah</th>
                              <th>Harga/Kg</th>
                              <th>Subtotal</th>
                              <th width="5%">Opsi</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                          </tfoot>
                        </table>
                    </div>
                  </div>
            </div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });

  $('#jumlah').on('input', function() {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
  });

  $('#id_pelanggan').on('change',function(){
    var telepon = $(this).children('option:selected').data('telepon');
    var alamat = $(this).children('option:selected').data('alamat');
    $('#telepon').val(telepon);
    $('#alamat').val(alamat);
  });
</script>

<script>
  $('#id_jasa').on('change',function(){
    var satuan = $(this).children('option:selected').data('satuan');
    var harga = $(this).children('option:selected').data('harga');
    $('#satuan').val(satuan);
    $('#harga').val(harga);

    $('#jumlah').on('keyup', function() {
      var jumlah = $('#jumlah').val();
      var totals = harga * jumlah;
      $('#subtotal').val(totals);    
    });
  });
  
  $(document).ready(function() {
      $('#btnReset').on('click', function() {
        $("#id_pelanggan option").prop("selected", false).trigger( "change");
        $("#notMember").hide();
        $("#memberInfo").show();
        $(this).prop('readonly', true);
        $('#id_pelanggan').removeAttr('readonly');
        $('#id_member').val('');    
        $('#saldo').val('');    
        $('#sisa').val('');
        $('#idpel').val('');
      });

      $('#btnKonfirmasi').on('click', function() {
        $(this).prop('readonly', true);
        $('#id_pelanggan').attr('readonly', 'readonly');  

        var id = $('#id_pelanggan').val();
        var urlData = "/kasir/check_member/"+id;
        
        $.ajax({
          type:"GET",
          url: urlData,
          dataType:"JSON",
          success : function(response) {
              if (response && response.length > 0) {  
                var len = response.length;
                for(var i=0; i<len; i++){     
                  console.log(response[i]);
                  var a = response[i].id;
                  var b = response[i].total_saldo;
                  var c = response[i].total_kg;                  
                  var d = response[i].id_pelanggan;                  
                  $('#id_member').val(a);    
                  $('#saldo').val(b);    
                  $('#sisa').val(c);
                  $('#idpel').val(d);
                }
              }
              else{
                $("#notMember").show();
                $("#memberInfo").hide();
                $('#idpel').val(d);
              }
          }
        }); 

      });
  });

</script>

<script>
  $('#addOrder').on('submit',function(e){
        e.preventDefault();
        var nama_jasa = $("#id_jasa :selected").text();
        let no_invoice = $('#no_invoice').val();
        let id_jasa = $('#id_jasa').val();
        let id_pelanggan = $('#id_pelanggan').val();
        let satuan = $('#satuan').val();
        let harga = $('#harga').val();
        let jumlah = $('#jumlah').val();
        let subtotal = $('#subtotal').val();

        $.ajax({
          url: "/kasir/insert_order",
          type:"POST",
          dataType:"JSON",
          data:{
            "_token": "{{ csrf_token() }}",
            no_invoice:no_invoice,
            id_jasa:id_jasa,
            nama_jasa:nama_jasa,
            id_pelanggan:id_pelanggan,
            satuan:satuan,
            harga:harga,
            jumlah:jumlah,
            subtotal:subtotal,
          },
          success:function(response){
            if (response) {
              successAdd();
              addRowTable();

              $("#id_jasa option").prop("selected", false).trigger( "change");
              $("#jumlah").val('');
              $("#harga").val('');
              $("#subtotal").val('');

            }
          },
          error: function(response) {
            warningOrder();
           }
         });
        });

        function successAdd(){
          Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Berhasil dimasukkan ke keranjang',
              showConfirmButton: true,
              confirmButtonColor: '#3085d6'
            })  
        }
        function warningOrder(){
          Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Pelanggan belum dipilih!',
              showConfirmButton: true,
              confirmButtonColor: '#3085d6'
            })  
        }

        function addRowTable(){
          var table = $('#tableCart').DataTable({
              processing: true,
              serverSide: true,
              paging: false,
              info: false,
              ordering: false,
              searching: false,
              stateSave: true,
              autoWidth: false, 
              lengthChange: false,
              destroy: true,
              ajax: "/kasir/get-order",
              columns: [
                  {data: 'nama_jasa', name: 'nama_jasa'},
                  {data: 'jumlah', name: 'jumlah'},
                  {data: 'harga', name: 'harga'},
                  {data: 'subtotal', name: 'subtotal'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
        }

</script>

<script type="text/javascript">
$('#tableCart').on('click', '.btn-delete[data-remote]', function (e) { 
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    // confirm then
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: {method: '_GET', submit: true}
    }).always(function (data) {
        $('#tableCart').DataTable().draw(false);
    });
});
</script>
@endpush