<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\WajibPajak;
use App\Models\TagihanPajak;
use App\Models\SPT;
use App\Models\ObjekPajak;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * User dashboard
     */
    public function user(Request $request)
    {
        $user = $request->user();

        // Default values for non-admin
        $tagihan = collect();
        $totalRevenue = 0;
        $totalTagihanBelumLunas = 0;
        $recentPayments = collect();

        // If admin, prepare admin-oriented data
        if ($user && $user->email === 'admin@demo.test') {
            // list all wajib pajak
            $wajibs = WajibPajak::with(['user','objekPajaks.tagihanPajaks'])->paginate(20);

            // pending SPT submissions for verification
            $pendingSpts = SPT::where('status_verifikasi', 'PENDING')->with('wajibPajak.user')->get();

            // recent payments overview
            $payments = Pembayaran::with(['user','tagihan.objekPajak'])->latest()->paginate(30);

            return view('user.dashboard', compact('wajibs','pendingSpts','payments'));
        }

        // Non-admin (regular user) flows
        if ($user && method_exists($user, 'wajibPajak') && $user->wajibPajak) {
            $wajib = $user->wajibPajak;
            $tagihan = ObjekPajak::with('tagihanPajaks')
                ->where('wajib_pajak_id', $wajib->id)
                ->get();

            $totalRevenue = Pembayaran::where('user_id', $user->id)
                ->where('status', 'SUCCESS')
                ->sum('jumlah_bayar');

            $totalTagihanBelumLunas = TagihanPajak::whereHas('objekPajak', function ($query) use ($wajib) {
                $query->where('wajib_pajak_id', $wajib->id);
            })
            ->where('status', 'BELUM_LUNAS')
            ->sum('jumlah_tagihan');

            $recentPayments = Pembayaran::where('user_id', $user->id)->latest()->limit(10)->get();
        }

        return view('user.dashboard', compact('tagihan', 'totalRevenue', 'recentPayments', 'totalTagihanBelumLunas'));
    }

    /**
     * Admin dashboard (kept as-is or implement separately)
     */
    public function admin()
    {
        // admin logic...
        $totalRevenue = Pembayaran::where('status','SUCCESS')->sum('jumlah_bayar');
        $activeTaxpayers = WajibPajak::count();
        $pendingSPT = \App\Models\SPT::where('status_verifikasi','PENDING')->count();

        return view('admin.dashboard', compact('totalRevenue','activeTaxpayers','pendingSPT'));
    }
}
