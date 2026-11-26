<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan notifikasi milik pengguna yang sedang login.
     */
    public function index()
    {
        $notifikasis = Notifikasi::where('id_pengguna', auth()->id())
            ->orderByDesc('waktu_dibuat')
            ->orderByDesc('id_notifikasi')
            ->get();

        return view('notifikasi.index', compact('notifikasis'));
    }

    /**
     * Menandai satu notifikasi milik pengguna sebagai sudah dibaca.
     */
    public function tandaiDibaca($id)
    {
        $notifikasi = Notifikasi::where('id_pengguna', auth()->id())
            ->findOrFail($id);

        $notifikasi->update([
            'status_notifikasi' => 'Sudah Dibaca',
        ]);

        return redirect()
            ->route('notifikasi.index')
            ->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}