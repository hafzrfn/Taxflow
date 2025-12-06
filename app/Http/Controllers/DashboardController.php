<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\WajibPajak;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * User dashboard
     */
    public function user(Request $request)
    {
        $user = $request->user();

        // Default empty collection
        $tagihan = collect();
        $totalRevenue = 0;

        // Check if the user has a wajib pajak relation
        if ($user && method_exists($user, 'wajibPajak') && $user->wajibPajak) {
            // Get objek pajak with tagihan (eager load)
            $wajib = $user->wajibPajak;
            // If objekPajaks relation exists, eager load tagihanPajaks
            $tagihan = \App\Models\ObjekPajak::with('tagihanPajaks')
                ->where('wajib_pajak_id', $wajib->id)
                ->get();

            // calculate user's total revenue (payments success)
            $totalRevenue = Pembayaran::where('user_id', $user->id)
                ->where('status', 'SUCCESS')
                ->sum('jumlah_bayar');
        }

        // recent payments (always a collection)
        $recentPayments = Pembayaran::where('user_id', $user->id)->latest()->limit(10)->get();

        return view('user.dashboard', compact('tagihan', 'totalRevenue', 'recentPayments'));
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
