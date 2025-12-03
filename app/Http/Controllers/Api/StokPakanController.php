<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StokPakan;
use App\Models\TransaksiPakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokPakanController extends Controller
{
    public function index()
    {
        return response()->json(StokPakan::all());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_pakan' => 'required|string',
                'stok_kg' => 'required|numeric',
                'harga_per_kg' => 'nullable|numeric',
            ]);

            $stok = StokPakan::create($validated);
            return response()->json($stok, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat stok pakan: ' . $e->getMessage()], 500);
        }
    }

    public function addTransaction(Request $request)
    {
        try {
            $validated = $request->validate([
                'stok_pakan_id' => 'required|exists:stok_pakans,id',
                'tipe' => 'required|in:masuk,keluar',
                'jumlah_kg' => 'required|numeric|min:0.1',
                'keterangan' => 'nullable|string',
            ]);

            $validated['user_id'] = $request->user()->id;

            DB::transaction(function () use ($validated) {
                // Catat transaksi
                TransaksiPakan::create($validated);

                // Update stok
                $stok = StokPakan::find($validated['stok_pakan_id']);
                if ($validated['tipe'] == 'masuk') {
                    $stok->increment('stok_kg', $validated['jumlah_kg']);
                } else {
                    $stok->decrement('stok_kg', $validated['jumlah_kg']);
                }
            });

            return response()->json(['message' => 'Transaksi berhasil dicatat']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mencatat transaksi: ' . $e->getMessage()], 500);
        }
    }
}
