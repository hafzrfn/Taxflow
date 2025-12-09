<?php

namespace App\Http\Controllers;

use App\Models\TagihanPajak;
use App\Models\WajibPajak;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class TagihanPajakController extends Controller
{
    /**
     * Display list of user's tagihan pajak
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        // Ambil semua tagihan user dari semua objek pajaknya
        $tagihans = TagihanPajak::whereHas('objekPajak', function ($query) use ($wajibPajak) {
            $query->where('wajib_pajak_id', $wajibPajak->id);
        })
        ->with('objekPajak', 'pembayaran')
        ->orderBy('tahun', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        $totalTagihan = TagihanPajak::whereHas('objekPajak', function ($query) use ($wajibPajak) {
            $query->where('wajib_pajak_id', $wajibPajak->id);
        })
        ->where('status', 'BELUM_LUNAS')
        ->sum('jumlah_tagihan');

        return view('tagihan-pajak.index', compact('tagihans', 'wajibPajak', 'totalTagihan'));
    }

    /**
     * Print SPPT (Surat Pemberitahuan Pajak Tahunan)
     */
    public function printSPPT(Request $request, $tagihanId)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        // Cek apakah tagihan milik user
        $tagihan = TagihanPajak::with('objekPajak')
                                ->whereHas('objekPajak', function ($query) use ($wajibPajak) {
                                    $query->where('wajib_pajak_id', $wajibPajak->id);
                                })
                                ->find($tagihanId);

        if (!$tagihan) {
            return redirect()->route('tagihan-pajak.index')->with('error', 'Tagihan tidak ditemukan');
        }

        return view('tagihan-pajak.sppt-print', compact('tagihan', 'wajibPajak', 'user'));
    }

    /**
     * Show detail tagihan
     */
    public function show(Request $request, $tagihanId)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $wajibPajak = $user->wajibPajak;
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        $tagihan = TagihanPajak::with('objekPajak', 'pembayaran')
                                ->whereHas('objekPajak', function ($query) use ($wajibPajak) {
                                    $query->where('wajib_pajak_id', $wajibPajak->id);
                                })
                                ->find($tagihanId);

        if (!$tagihan) {
            return redirect()->route('tagihan-pajak.index')->with('error', 'Tagihan tidak ditemukan');
        }

        return view('tagihan-pajak.show', compact('tagihan', 'wajibPajak'));
    }
}
