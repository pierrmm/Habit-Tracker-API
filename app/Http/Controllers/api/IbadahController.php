<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ibadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IbadahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ibadahs = Ibadah::all();

        return response()->json([
            'status' => 'success',
            'data' => $ibadahs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ibadah' => 'required|string|min:3',
            'jenis_ibadah' => 'required|in:wajib,sunah',
            'tanggal_ibadah' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $ibadah = Ibadah::create([
            'nama_ibadah' => $request->nama_ibadah,
            'jenis_ibadah' => $request->jenis_ibadah,
            'tanggal_ibadah' => $request->tanggal_ibadah,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ibadah berhasil ditambahkan',
            'data' => $ibadah
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ibadah = Ibadah::find($id);

        if (!$ibadah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ibadah tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $ibadah
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ibadah = Ibadah::find($id);

        if (!$ibadah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ibadah tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_ibadah' => 'sometimes|required|string|min:3',
            'jenis_ibadah' => 'sometimes|required|in:wajib,sunah',
            'tanggal_ibadah' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $ibadah->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Ibadah berhasil diperbarui',
            'data' => $ibadah
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ibadah = Ibadah::find($id);

        if (!$ibadah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ibadah tidak ditemukan'
            ], 404);
        }

        $ibadah->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Ibadah berhasil dihapus'
        ]);
    }
}
