<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Models\ObjekPajak;
use App\Models\TagihanPajak;
use App\Models\SPT;
use App\Models\Pembayaran;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalWajib = WajibPajak::count();
        $totalObjek = ObjekPajak::count();
        $totalTagihan = TagihanPajak::count();
        $totalPayments = Pembayaran::count();

        return view('admin.dashboard', compact('totalWajib','totalObjek','totalTagihan','totalPayments'));
    }

    public function wajibPajaks()
    {
        $wajibs = WajibPajak::withCount('objekPajaks')->paginate(20);
        return view('admin.wajibpajaks.index', compact('wajibs'));
    }

    public function showWajibPajak($id)
    {
        $wajib = WajibPajak::with(['objekPajaks.tagihanPajaks','user'])->findOrFail($id);
        // SPTs for this wajib
        $spts = SPT::where('wajib_pajak_id', $wajib->id)->get();
        return view('admin.wajibpajaks.show', compact('wajib','spts'));
    }

    public function verifySpt(Request $request, $sptId)
    {
        $spt = SPT::findOrFail($sptId);
        $spt->status_verifikasi = 'VERIFIED';
        $spt->save();

        return redirect()->back()->with('success','SPT diverifikasi.');
    }

    public function payments()
    {
        $payments = Pembayaran::with(['user','tagihan.objekPajak'])->latest()->paginate(30);
        return view('admin.payments.index', compact('payments'));
    }
}
