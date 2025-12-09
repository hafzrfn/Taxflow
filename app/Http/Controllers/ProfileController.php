<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\WajibPajak;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan form edit profil
    public function edit(Request $request)
    {
        $user = $request->user();

        // Do not auto-create a WajibPajak with a TEMP NIK here. If one doesn't exist,
        // pass a new (unsaved) model to the view so the form shows empty values.
        // Creating a TEMP NIK record caused users' real NIKs to be overwritten.
        // Reload the user with fresh WajibPajak data (important after registration).
        $user = \App\Models\User::with('wajibPajak')->find($user->id);
        $wajibPajak = $user->wajibPajak ?? new WajibPajak();

        return view('profile.edit', [
            'user' => $user,
            'wajibPajak' => $wajibPajak,
        ]);
    }

    // Simpan perubahan profil
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        // update user basic (name, email optional)
        $user->name = $data['name'] ?? $user->name;
        // jika ingin user bisa ubah email uncomment: $user->email = $data['email'];
        $user->save();

        // update atau buat WajibPajak
        $wajib = $user->wajibPajak;
        if (!$wajib) {
            $wajib = new WajibPajak();
            $wajib->user_id = $user->id;
        }

        // isi field WajibPajak
        $wajib->nik = $data['nik'] ?? $wajib->nik;
        $wajib->no_hp = $data['no_hp'] ?? $wajib->no_hp;
        $wajib->alamat = $data['alamat'] ?? $wajib->alamat;

        // jika NIK diisi, set status ke PENDING_VERIF (administratif)
        if (!empty($data['nik'])) {
            $wajib->status = 'PENDING_VERIF';
        }

        $wajib->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    // optional: destroy profile (keep or remove)
    public function destroy(Request $request)
    {
        $user = $request->user();
        // implement if required
        return redirect()->route('dashboard')->with('info', 'Fitur hapus akun belum diimplementasikan.');
    }
}
