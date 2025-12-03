<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanHarianController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanHarian::with(['kandang', 'user']);

        if ($request->has('kandang_id')) {
            $query->where('kandang_id', $request->kandang_id);
        }

        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        return response()->json($query->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kandang_id' => 'required|exists:kandangs,id',
                'tanggal' => 'required|date',
                'jumlah_telur' => 'required|integer',
                'ayam_mati' => 'required|integer',
                'ayam_sakit' => 'required|integer',
                'pakan_kg' => 'required|numeric',
                'suhu_kandang' => 'nullable|numeric',
                'catatan' => 'nullable|string',
            ]);

            $validated['user_id'] = $request->user()->id;

            DB::transaction(function () use ($validated) {
                // Simpan laporan
                $laporan = LaporanHarian::create($validated);

                // Update jumlah ayam di kandang (kurangi yang mati)
                if ($validated['ayam_mati'] > 0) {
                    $kandang = Kandang::find($validated['kandang_id']);
                    if ($kandang) {
                        $kandang->decrement('jumlah_ayam', $validated['ayam_mati']);
                    }
                }
            });

            return response()->json(['message' => 'Laporan berhasil disimpan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan laporan: ' . $e->getMessage()], 500);
        }
    }
}
