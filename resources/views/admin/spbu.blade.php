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
                    <table class="table table-bordered table-hover table-striped datatable yajra-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Template</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $i->number }}</td>
                                    <td>{{ $i->name }}</td>
                                    <td>{{ $i->address }}</td>
                                    <td>{{ $i->template->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" data-id="{{ $i->id }}" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-eye"></i></button>
                                            <button type="button" data-id="{{ $i->id }}" data-name="{{ $i->name }}" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
    $(document).ready(function() {
        $(document).on("click", '.btn-edit', function() {
            let id = $(this).attr("data-id");
            $('#modal-loading').modal({backdrop: 'static', keyboard: false, show: true});
            $.ajax({
                url: "{{ route('admin.spbu.data') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $("#number").val(data.number);
                    $("#name").val(data.name);
                    $("#address").val(data.address);
                    $("#template_id").val(data.template_id);
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
    });
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
            <form action="{{ route('admin.spbu.create') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>Nomor</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('number') is-invalid @enderror" placeholder="Type number..." name="number" value="{{ old('number') }}" required>
                        @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Nama</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Type name..." name="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Alamat</label>
                    <div class="input-group">
                        <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Type address..." name="address">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Template</label>
                    <div class="input-group">
                        <select class="form-control @error('template_id') is-invalid @enderror" name="template_id" value="{{ old('template_id') }}" required>
                            @foreach ($dtemp as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                        @error('template_id')
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
            <form action="{{ route('admin.spbu.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <label>Nomor</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('number') is-invalid @enderror" placeholder="Type number..." name="number" id="number" value="{{ old('number') }}" required>
                        @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Nama</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Type name..." name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Alamat</label>
                    <div class="input-group">
                        <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Type address..." name="address" id="address">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Template</label>
                    <div class="input-group">
                        <select class="form-control @error('template_id') is-invalid @enderror" name="template_id" id="template_id" value="{{ old('template_id') }}" required>
                            @foreach ($dtemp as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                        @error('template_id')
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
            <form action="{{ route('admin.spbu.delete') }}" method="POST" enctype="multipart/form-data">
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