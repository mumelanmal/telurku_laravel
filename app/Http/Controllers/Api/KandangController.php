<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index()
    {
        return response()->json(Kandang::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kandang' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'jumlah_ayam' => 'integer',
            'keterangan' => 'nullable|string',
        ]);

        $kandang = Kandang::create($validated);

        return response()->json($kandang, 201);
    }

    public function show($id)
    {
        return response()->json(Kandang::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kandang = Kandang::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kandang' => 'string|max:255',
            'kapasitas' => 'integer',
            'jumlah_ayam' => 'integer',
            'keterangan' => 'nullable|string',
        ]);

        $kandang->update($validated);

        return response()->json($kandang);
    }

    public function destroy($id)
    {
        Kandang::findOrFail($id)->delete();
        return response()->json(['message' => 'Kandang berhasil dihapus']);
    }
}
