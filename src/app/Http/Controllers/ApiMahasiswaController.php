<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiMahasiswaController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Invalid login credentials',
        ], 401);
    }

    public function logout(Request $request)
    {
 
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function index()
    {
        $mahasiswas = Mahasiswa::all();

        // Mengubah data untuk menyertakan URL foto
        $mahasiswas->each(function ($mahasiswa) {
            if ($mahasiswa->foto) {
                $mahasiswa->foto_url = asset('storage/' . $mahasiswa->foto);
            }
        });

        return response()->json($mahasiswas, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'tanggal_lahir' => 'required|date',
            'semester' => 'required|integer',
            'jurusan' => 'required',
            'foto' => 'image|nullable',
        ]);

        $path = $request->file('foto') ? $request->file('foto')->store('fotos', 'public') : null;

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'tanggal_lahir' => $request->tanggal_lahir,
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'foto' => $path,
        ]);

        return response()->json($mahasiswa, 201);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($mahasiswa->foto) {
            $mahasiswa->foto_url = asset('storage/' . $mahasiswa->foto);
        }

        return response()->json($mahasiswa, 200);
    }

    public function update(Request $request, $id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'nim' => 'required|string|max:10|unique:mahasiswas,nim,' . $mahasiswa->id,
        'tanggal_lahir' => 'required|date',
        'semester' => 'required|integer|min:1',
        'jurusan' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Mengupload foto jika ada file baru yang diupload
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
        // Simpan foto baru
        $path = $request->file('foto')->store('fotos', 'public');
    } else {
        // Gunakan foto lama jika tidak ada foto baru yang diupload
        $path = $mahasiswa->foto;
    }

    // Update data mahasiswa
    $mahasiswa->update([
        'nama' => $request->nama,
        'nim' => $request->nim,
        'tanggal_lahir' => $request->tanggal_lahir,
        'semester' => $request->semester,
        'jurusan' => $request->jurusan,
        'foto' => $path,
    ]);

    // Respon dengan data yang diupdate dan pesan sukses
    return response()->json([
        'message' => 'Data mahasiswa berhasil diperbarui',
        'mahasiswa' => $mahasiswa
    ], 200);
}


    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('fotos', 'public');

            // Simpan path di database
            $mahasiswa->foto = $path;
            $mahasiswa->save();

            return response()->json(['url' => Storage::url($path)], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function destroy($id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    if ($mahasiswa->foto) {
        Storage::delete($mahasiswa->foto);
    }

    $mahasiswa->delete();

    return response()->json(['message' => 'Data berhasil dihapus'], 200);
}

}
