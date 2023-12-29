<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return response()->json([
            'success' => true,
            'message' => 'List Mahasiswa',
            'data' => $mahasiswas
        ], 200);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Mahasiswa',
            'data' => $mahasiswa
        ], 200);
    }

    public function showByNim($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => "Mahasiswa dengan NIM '" . $nim . "' tidak ditemukan."], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Mahasiswa',
            'data' => $mahasiswa
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'jurusan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan.',
            'data' => $mahasiswa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim,' . $id,
            'jurusan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $mahasiswa->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil diupdate.',
            'data' => $mahasiswa
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $mahasiswa->delete();

        return response()->json(['message' => 'Mahasiswa berhasil dihapus.']);
    }
}
