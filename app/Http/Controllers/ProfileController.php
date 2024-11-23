<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tidak diperlukan implementasi, tidak digunakan.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kosong, tidak digunakan.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Kosong, tidak digunakan.
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data['profile'] = User::where('id', $id)->first();
            return view('profile.index', $data);
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data profil.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Kosong, tidak digunakan.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validasi data yang masuk
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id, // Biarkan email yang sama tetap
            ]);

            // Temukan pengguna berdasarkan ID
            $profile = User::findOrFail($id);

            // Perbarui profil pengguna dengan data yang sudah divalidasi
            $profile->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            // Redirect atau kembalikan respons
            return redirect()->route('profile', ['id' => $id])->with('success', 'Profil berhasil diperbarui.');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan yang tidak terduga.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Kosong, jika dibutuhkan untuk menghapus data.
    }

    /**
     * Handle password change.
     */
    public function changePassword(Request $request)
    {
        try {
            // Validasi data yang masuk
            $validated = $request->validate([
                'password' => 'required|string|min:5', // Kata sandi saat ini
                'newpassword' => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', // Kata sandi baru dan konfirmasi
            ]);

            // Ambil pengguna yang sedang login
            $user = Auth::user();

            // Verifikasi apakah kata sandi saat ini sesuai
            if (!Hash::check($validated['password'], $user->password)) {
                return back()->withErrors(['password' => 'Kata sandi saat ini tidak benar.']);
            }

            // Update kata sandi pengguna
            $user->password = Hash::make($validated['newpassword']);
            $user->save();

            // Redirect dengan pesan sukses
            return redirect()->route('profile', ['id' => $user->id])->with('success', 'Kata sandi berhasil diubah.');
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kata sandi.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan yang tidak terduga.']);
        }
    }
}
