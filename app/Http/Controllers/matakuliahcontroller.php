<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Jurusan;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Mata Kuliah";

        $perPage = $request->get('per_page', 10);
        $matakuliah = Matakuliah::with('jurusan')->latest()->paginate($perPage);
        $jurusan = Jurusan::all();

        return view('matakuliah.index', compact('matakuliah', 'jurusan', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_matakuliah' => 'required',
            'sks' => 'required|numeric',
            'id_jurusan' => 'required|exists:tb_jurusan,id_jurusan'
        ]);

        Matakuliah::create([
            'nama_matakuliah' => $request->nama_matakuliah,
            'sks' => $request->sks,
            'id_jurusan' => $request->id_jurusan
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil disimpan');
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Mata Kuliah";

        $editData = Matakuliah::findOrFail($id);
        $perPage = $request->get('per_page', 10);
        $matakuliah = Matakuliah::with('jurusan')->latest()->paginate($perPage);
        $jurusan = Jurusan::all();

        return view('matakuliah.index', compact('matakuliah', 'tb_jurusan', 'editData', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_matakuliah' => 'required',
            'sks' => 'required|numeric',
            'id_jurusan' => 'required|exists:jurusan,id_jurusan'
        ]);

        $matakuliah = Matakuliah::findOrFail($id);

        $matakuliah->update([
            'nama_matakuliah' => $request->nama_matakuliah,
            'sks' => $request->sks,
            'id_jurusan' => $request->id_jurusan
        ]);

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil diupdate');
    }

    public function destroy($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data matakuliah berhasil dihapus');
    }
}