<?php

namespace App\Http\Controllers;

use App\Models\alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $alats = alat::latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $alats,
            ]);
        }

        return view('alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'digits:4', 'integer'],
            'merek' => ['required', 'string', 'max:60'],
            'lokasi' => ['required', 'string', 'max:10'],
        ], [
            'nama_alat.required' => 'Nama alat medis wajib diisi.',
            'nama_alat.max' => 'Nama alat maksimal 100 karakter.',
            'tahun.required' => 'Tahun pengadaan wajib diisi.',
            'tahun.digits' => 'Format tahun harus 4 digit (contoh: 2024).',
            'merek.required' => 'Merek alat wajib diisi.',
            'merek.max' => 'Merek alat maksimal 60 karakter.',
            'lokasi.required' => 'Lokasi ruangan wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 10 karakter (contoh: IGD, ICU, POLI).',
        ]);

        $alat = alat::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data alat medis berhasil ditambahkan!',
                'data' => $alat,
            ], 201);
        }

        return redirect()->route('alat.index')->with('success', 'Data alat medis berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alat = alat::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $alat,
            ]);
        }

        return view('alat.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alat = alat::findOrFail($id);
        return view('alat.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alat = alat::findOrFail($id);

        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'digits:4', 'integer'],
            'merek' => ['required', 'string', 'max:60'],
            'lokasi' => ['required', 'string', 'max:10'],
        ], [
            'nama_alat.required' => 'Nama alat medis wajib diisi.',
            'nama_alat.max' => 'Nama alat maksimal 100 karakter.',
            'tahun.required' => 'Tahun pengadaan wajib diisi.',
            'tahun.digits' => 'Format tahun harus 4 digit.',
            'merek.required' => 'Merek alat wajib diisi.',
            'merek.max' => 'Merek alat maksimal 60 karakter.',
            'lokasi.required' => 'Lokasi ruangan wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 10 karakter.',
        ]);

        $alat->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data alat medis berhasil diperbarui!',
                'data' => $alat,
            ]);
        }

        return redirect()->route('alat.index')->with('success', 'Data alat medis berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alat = alat::findOrFail($id);
        $alat->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data alat medis berhasil dihapus!',
            ]);
        }

        return redirect()->route('alat.index')->with('success', 'Data alat medis berhasil dihapus!');
    }
}
