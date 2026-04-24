@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="container content-wrapper">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card jurusan-card mb-4 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">{{ isset($editData) ? 'Edit Data Jurusan' : 'Form Input Jurusan' }}</h5>
        </div>

        <div class="card-body">
            @php
                $formAction = isset($editData) 
                    ? route('jurusan.update', array_merge(['jurusan' => $editData->id_jurusan], request()->query())) 
                    : route('jurusan.store', request()->query());
            @endphp

            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if(isset($editData)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" value="{{ $editData->nama_jurusan ?? old('nama_jurusan') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Akreditasi</label>
                        <select name="akreditasi" class="form-control" required>
                            <option value="">-- Pilih Akreditasi --</option>
                            @foreach(['A', 'B', 'C'] as $grade)
                                <option value="{{ $grade }}" {{ (isset($editData) && $editData->akreditasi == $grade) || old('akreditasi') == $grade ? 'selected' : '' }}>
                                    {{ $grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($editData) ? 'Update' : 'Simpan' }}</button>
                @if(isset($editData))
                    <a href="{{ route('jurusan.index', request()->query()) }}" class="btn btn-secondary">Batal</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card jurusan-card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Jurusan</h5>
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
                            <th>Nama Jurusan</th>
                            <th>Akreditasi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusan as $j)
                            <tr>
                                {{-- Nomor urut menyesuaikan halaman --}}
                                <td>{{ $jurusan->firstItem() + $loop->index }}</td>
                                <td>{{ $j->nama_jurusan }}</td>
                                <td><span class="badge bg-info text-dark">{{ $j->akreditasi }}</span></td>
                                <td>
                                    <a href="{{ route('jurusan.edit', array_merge(['jurusan' => $j->id_jurusan], request()->query())) }}" class="btn btn-warning btn-sm">Edit</a>
                                    
                                    <form id="delete-form-{{ $j->id_jurusan }}" action="{{ route('jurusan.destroy', $j->id_jurusan) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $j->id_jurusan }}')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Tidak ada data jurusan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Navigasi Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $jurusan->firstItem() ?? 0 }} to {{ $jurusan->lastItem() ?? 0 }} of {{ $jurusan->total() }} entries
                </div>
                <div class="d-flex align-items-center gap-3">
                    {{ $jurusan->appends(request()->query())->links('pagination::bootstrap-5') }}
                    
                    <div class="d-flex align-items-center gap-2 border-start ps-3">
                        <span class="small text-muted">Go to</span>
                        <input type="number" class="form-control form-control-sm text-center" style="width: 50px;" 
                               onkeypress="if(event.key === 'Enter') { 
                                   let url = new URL(window.location.href);
                                   url.searchParams.set('page', this.value);
                                   window.location.href = url.href;
                               }">
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