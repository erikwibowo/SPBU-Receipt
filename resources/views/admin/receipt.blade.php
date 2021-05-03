@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Tambah</a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped yajra-datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Shift</th>
                                <th>Tanggal</th>
                                <th>Pompa</th>
                                <th>Produk</th>
                                <th>Harga/Liter</th>
                                <th>Voume (L)</th>
                                <th>Total</th>
                                <th>No. Kendaraan</th>
                                <th>Operator</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
    </div>
<script>
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.struk.index') }}",
            columns: [
                {data: 'receipt_number',},
                {data: 'shift',},
                {data: 'date',},
                {data: 'pump_number',},
                {data: 'product',},
                {data: 'rate',},
                {data: 'volume',},
                {data: 'price',},
                {data: 'vehicle_number',},
                {data: 'operator',},
                {data: 'action', orderable: false, searchable: true },
            ]
        });
    });
    $(document).ready(function() {
        $(document).on("click", '.btn-edit', function() {
            let id = $(this).attr("data-id");
            $('#modal-loading').modal({backdrop: 'static', keyboard: false, show: true});
            $.ajax({
                url: "{{ route('admin.struk.data') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $("#receipt_number").val(data.receipt_number);
                    $("#shift").val(data.shift);
                    $("#date").val(data.date);
                    $("#pump_number").val(data.pump_number);
                    $("#product").val(data.product);
                    $("#rate").val(data.rate);
                    $("#volume").val(data.volume);
                    $("#price").val(data.price);
                    $("#vehicle_number").val(data.vehicle_number);
                    $("#operator").val(data.operator);
                    $("#spbu_id").val(data.spbu_id);
                    $("#id").val(data.id);
                    $('#modal-loading').modal('hide');
                    $('#modal-edit').modal({backdrop: 'static', keyboard: false, show: true});
                },
            });
        });
        $(document).on("click", '.btn-delete', function() {
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            $("#did").val(id);
            $("#delete-data").html(name);
            $('#modal-delete').modal({backdrop: 'static', keyboard: false, show: true});
        });
        

        $("#ph").on("change", function(){
            readURL(this);
        });

        $("#trate").on("input", function(){
            $("#tprice").val(total($(this).val(), $("#tvolume").val()));
        });

        $("#tvolume").on("input", function(){
            $("#tprice").val(total($("#trate").val(), $(this).val()));
        });

        $("#erate").on("input", function(){
            $("#eprice").val(total($(this).val(), $("#evolume").val()));
        });

        $("#evolume").on("input", function(){
            $("#eprice").val(total($("#erate").val(), $(this).val()));
        });

        function total(rate, volume){
            return rate*volume;
        }
        
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#photo').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.struk.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <label>No. Transaksi*</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('receipt_number') is-invalid @enderror" placeholder="No. Transaksi" name="receipt_number" value="{{ old('receipt_number') }}" required>
                        @error('receipt_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Shift</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('shift') is-invalid @enderror" placeholder="Shift" name="shift" value="{{ old('shift') }}">
                        @error('shift')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Tanggal*</label>
                    <div class="input-group">
                        <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" placeholder="Tanggal" name="date" value="{{ old('date') }}" required>
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Nomor Pompa*</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('pump_number') is-invalid @enderror" placeholder="Nomor Pompa" name="pump_number" value="{{ old('pump_number') }}" required>
                        @error('pump_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Produk*</label>
                    <div class="input-group">
                        <select class="form-control @error('product') is-invalid @enderror" name="product" value="{{ old('product') }}" required>
                            <option value="PERTAMAX">PERTAMAX</option>
                            <option value="PERTALITE">PERTALITE</option>
                        </select>
                        @error('product')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Harga/Liter*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('rate') is-invalid @enderror" placeholder="Harga/Liter" name="rate" id="trate" value="{{ old('rate') }}" required>
                        @error('rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Volume*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('volume') is-invalid @enderror" placeholder="Volume" name="volume" id="tvolume" value="{{ old('volume') }}" required>
                        @error('volume')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Total*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Total" name="price" id="tprice" value="{{ old('price') }}" required readonly>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>No. Kendaraan</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" placeholder="No. Kendaraan" name="vehicle_number" value="{{ old('vehicle_number') }}">
                        @error('vehicle_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Operator</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('operator') is-invalid @enderror" placeholder="Operator" name="operator" value="{{ old('operator') }}">
                        @error('operator')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>SPBU</label>
                    <div class="input-group">
                        <select class="form-control @error('spbu_id') is-invalid @enderror" name="spbu_id" value="{{ old('spbu_id') }}" required>
                            @foreach ($spbu as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                        @error('spbu_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.struk.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <label>No. Transaksi*</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('receipt_number') is-invalid @enderror" placeholder="No. Transaksi" name="receipt_number" id="receipt_number" value="{{ old('receipt_number') }}" required>
                        @error('receipt_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Shift</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('shift') is-invalid @enderror" placeholder="Shift" name="shift" id="shift" value="{{ old('shift') }}">
                        @error('shift')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Tanggal*</label>
                    <div class="input-group">
                        <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" placeholder="Tanggal" name="date" id="date" value="{{ old('date') }}" required>
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Nomor Pompa*</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('pump_number') is-invalid @enderror" placeholder="Nomor Pompa" name="pump_number" id="pump_number" value="{{ old('pump_number') }}" required>
                        @error('pump_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Produk*</label>
                    <div class="input-group">
                        <select class="form-control @error('product') is-invalid @enderror" name="product" id="product" value="{{ old('product') }}" required>
                            <option value="PERTAMAX">PERTAMAX</option>
                            <option value="PERTALITE">PERTALITE</option>
                        </select>
                        @error('product')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Harga/Liter*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('rate') is-invalid @enderror" placeholder="Harga/Liter" name="rate" id="erate" value="{{ old('rate') }}" required>
                        @error('rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Volume*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('volume') is-invalid @enderror" placeholder="Volume" name="volume" id="evolume" value="{{ old('volume') }}" required>
                        @error('volume')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Total*</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Total" name="price" id="eprice" value="{{ old('price') }}" required readonly>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>No. Kendaraan</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" placeholder="No. Kendaraan" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number') }}">
                        @error('vehicle_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Operator</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('operator') is-invalid @enderror" placeholder="Operator" name="operator" id="operator" value="{{ old('operator') }}">
                        @error('operator')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>SPBU</label>
                    <div class="input-group">
                        <select class="form-control @error('spbu_id') is-invalid @enderror" name="spbu_id" id="spbu_id" value="{{ old('spbu_id') }}" required>
                            @foreach ($spbu as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                        @error('spbu_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
            <input type="hidden" name="id" id="id">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.struk.delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                <input type="hidden" name="id" id="did">
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection