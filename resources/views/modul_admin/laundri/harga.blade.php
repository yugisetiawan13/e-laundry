@extends('layouts.admin_template')
@section('title','Admin - Data Harga Laundri')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <a class="btn btn-sm btn-primary" style="color:white">Tambah</a>
                    </h4>
                    <div class="table-responsive m-t-0">
                        <table id="myTable" class="table display table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis</th>
                                    <th>Lama</th>
                                    <th>Kg</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Cabang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach ($harga as $item)
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$item->jenis}}</td>
                                    <td>{{$item->hari}} Hari</td>
                                    <td>{{$item->kg}} Kg</td>
                                    <td>Rp. {{$item->harga}}</td>
                                    <td>
                                        @if ($item->status == "1")
                                            <span class="label label-primary">Aktif</span>
                                        @else
                                        <span class="label label-warning">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{$item->nama_cabang}}</td>
                                    <td>
                                        <form action="{{url('customer-delete', $item->id_customer)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-sm btn-success" data-toggle="modal" data-id="{{$item->id}}" data-id-jenis="{{$item->jenis}}" data-id-kg="{{$item->kg}}" data-id-harga="{{$item->harga}}" data-id-hari="{{$item->hari}}" data-id-status="{{$item->status}}" id="click_harga" data-target="#edit_harga" style="color:white">Edit</a>
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @include('modul_admin.laundri.editharga')
                </div>
            </div>
        </div>
       
        <div class="col-lg-4">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form Tambah Data Harga</h4>
                </div>
                <div class="card-body">
                    <form action="{{url('harga-store')}}" method="POST">
                        @csrf
                        <div class="form-body">
                            @if ($karyawan == !null)
                            <div class="row p-t-20">
                                
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Cabang</label>
                                        <select name="id_cabang" class="form-control" required>
                                            <option value="">-- Pilih Cabang --</option>
                                            @foreach ($getcabang as $item)
                                                <option value="{{$item->id}}">{{$item->nama_cabang}} - {{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Jenis Pakaian</label>
                                        <input type="text" name="jenis" value="{{ old('jenis') }}" class="form-control" placeholder="Tambahkan Jenis Pakaian" required autocomplete="off">
                                        <small class="form-control-feedback "> Pisahkan Dengan format '+' Jika Jenis Lebih Dari Satu </small>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Berat Per-Kg</label>
                                        <input type="number" class="form-control form-control-danger" name="kg" value="{{ old('kg') }}" placeholder="Berat" autocomplete="off" required>
                                        <small class="form-control-feedback "> Tulisakan Angka 1-10 </small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--/span-->
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Harga Per-Kg</label>
                                        <input type="number" class="form-control form-control-danger" name="harga" value="{{ old('harga') }}"placeholder="Harga Per-Kg" autocomplete="off" required>
                                        <small class="form-control-feedback "> Tuliskan Tanpa tanda ',' dan '.' </small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12">
                                    <div class="form-group has-success">
                                        <label class="control-label">Lama Hari</label>
                                        <input type="number" name="hari" value="{{ old('hari') }}" class="form-control" placeholder="Lama Hari" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->      
                                        
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                        @else
                            <h4>Upsss, data karyawan masih kosong nih !!!</h4> <br>
                            <a href="{{url('kry')}}" class="btn btn-success btn-block">Tambah Karyawan</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

// Tampilkan Modal Edit Harga
$(document).on('click','#click_harga', function(){
    var id = $(this).attr('data-id');
    var jenis = $(this).attr('data-id-jenis');
    var kg = $(this).attr('data-id-kg');
    var hari = $(this).attr('data-id-hari');
    var harga = $(this).attr('data-id-harga');
    var status = $(this).attr('data-id-status');
    $("#id_harga").val(id)
    $("#jenis").val(jenis)
    $("#kg").val(kg)
    $("#hari").val(hari)
    $("#harga").val(harga)
    $("#status").val(status)

});
// Proses Edit harga
$(document).on('click','#simpan_harga', function(){
    var id_harga = $("#id_harga").val();
    var jenis = $("#jenis").val();
    var kg = $("#kg").val();
    var hari = $("#hari").val();
    var harga = $("#harga").val();
    var status = $("#status").val();
    
    $.get('{{Url("edit-harga")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id_harga:id_harga,hari:hari,jenis:jenis,kg:kg,harga:harga,status:status}, function(resp){
            swal({
            html :  "Berhasil Edit Harga",
            showConfirmButton :  false,
            type: "success",
            timer: 1000 
            });
        $("#id_harga").val(''); 
        $("#jenis").val('');
        $("#kg").val('');
        $("#hari").val('');
        $("#harga").val(''); 
        $("#status").val('');  
        location.reload();
    });
 });


 $(document).ready(function() {
    $('#myTable').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
    });
});
</script>
@endsection