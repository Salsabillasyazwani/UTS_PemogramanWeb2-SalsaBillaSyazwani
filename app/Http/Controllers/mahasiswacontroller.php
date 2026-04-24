<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Jurusan;

class MahasiswaController extends Controller
{
    public function index()
    {
        $title = "Data Mahasiswa";

        $mahasiswa = Mahasiswa::with('detail_jurusan')->paginate(10);
        $jurusan = Jurusan::all();

        return view('mahasiswa.index', compact('mahasiswa', 'jurusan', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'id_jurusan' => 'required'
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan
        ]);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil disimpan');
    }

    public function edit($id)
    {
        $title = "Edit Mahasiswa";

        $editData = Mahasiswa::findOrFail($id);
        $mahasiswa = Mahasiswa::with('detail_jurusan')->paginate(10);
        $jurusan = Jurusan::all();

        return view('mahasiswa.index', compact('mahasiswa', 'jurusan', 'editData', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'id_jurusan' => 'required'
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan
        ]);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus');
    }
}