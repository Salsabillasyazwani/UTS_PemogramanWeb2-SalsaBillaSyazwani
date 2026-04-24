@extends('layouts.app')

@section('title', 'Data Matakuliah')

@section('content')
<div class="container content-wrapper">

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card jurusan-card mb-4 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                {{ isset($editData) ? 'Edit Data Matakuliah' : 'Form Input Matakuliah' }}
            </h5>
        </div>

        <div class="card-body">
            @php
                $formAction = isset($editData) 
                    ? route('matakuliah.update', array_merge(['matakuliah' => $editData->id_matakuliah], request()->query())) 
                    : route('matakuliah.store', request()->query());
            @endphp

            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if(isset($editData)) @method('PUT') @endif
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" name="nama_matakuliah" class="form-control" value="{{ $editData->nama_matakuliah ?? old('nama_matakuliah') }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" class="form-control" value="{{ $editData->sks ?? old('sks') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="id_jurusan" class="form-control" required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusan as $j)
                                <option value="{{ $j->id_jurusan }}" 
                                    {{ (isset($editData) && $editData->id_jurusan == $j->id_jurusan) || old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                    {{ $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($editData) ? 'Update' : 'Simpan' }}</button>
                @if(isset($editData))
                    <a href="{{ route('matakuliah.index', request()->query()) }}" class="btn btn-secondary">Batal</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="card jurusan-card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Matakuliah</h5>
            <div>
                <select class="form-select form-select-sm d-inline-block w-auto" onchange="changePerPage(this.value)">
                    @foreach([10, 25, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Matakuliah</th>
                            <th>SKS</th>
                            <th>Jurusan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matakuliah as $m)
                            <tr>
                                {{-- Nomor urut yang benar untuk pagination --}}
                                <td>{{ $matakuliah->firstItem() + $loop->index }}</td>
                                <td>{{ $m->nama_matakuliah }}</td>
                                <td>{{ $m->sks }}</td>
                                <td>{{ $m->jurusan->nama_jurusan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('matakuliah.edit', array_merge(['matakuliah' => $m->id_matakuliah], request()->query())) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('matakuliah.destroy', $m->id_matakuliah) }}" method="POST" class="d-inline" id="delete-form-{{ $m->id_matakuliah }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $m->id_matakuliah }}')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Tidak ada data matakuliah.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info & Navigasi Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $matakuliah->firstItem() ?? 0 }} to {{ $matakuliah->lastItem() ?? 0 }} of {{ $matakuliah->total() }} entries
                </div>
                <div class="d-flex align-items-center gap-3">
                    {{ $matakuliah->appends(request()->query())->links('pagination::bootstrap-5') }}
                    
                    <div class="d-flex align-items-center gap-2 border-start ps-3">
                        <span class="small text-muted">Go to</span>
                        <input type="number" class="form-control form-control-sm text-center" style="width: 50px;" 
                               onkeypress="if(event.key === 'Enter') { window.location.href = '{{ $matakuliah->url(1) }}'.replace('page=1', 'page=' + this.value) }">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah yakin?',
            text: 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection