<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Jurusan";
        $perPage = $request->get('per_page', 10);
        $jurusan = Jurusan::latest()->paginate($perPage);

        return view('jurusan.index', compact('jurusan', 'title'));
    }

    public function create()
    {
        return redirect()->route('jurusan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'akreditasi' => 'required'
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'akreditasi' => $request->akreditasi
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Jurusan";
        $editData = Jurusan::findOrFail($id);
        
        $perPage = $request->get('per_page', 10);
        $jurusan = Jurusan::latest()->paginate($perPage);

        return view('jurusan.index', compact('jurusan', 'editData', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'akreditasi' => 'required'
        ]);

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
            'akreditasi' => $request->akreditasi
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil diupdate');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus');
    }
}