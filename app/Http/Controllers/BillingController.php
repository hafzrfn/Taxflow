<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjekPajak;
use App\Models\Pembayaran;
use App\Models\TagihanPajak;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Show list of tagihan for the authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $tagihan = collect();
        $recentPayments = collect();

        if ($user && $user->wajibPajak) {
            // Eager load relation: objekPajaks -> tagihanPajaks -> pembayaran
            $tagihan = ObjekPajak::with(['tagihanPajaks.pembayaran'])
                ->where('wajib_pajak_id', $user->wajibPajak->id)
                ->get();

            $recentPayments = Pembayaran::where('user_id', $user->id)
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('payments.list', compact('tagihan', 'recentPayments'));
    }

    /**
     * Create payment for a tagihan (e-Billing)
     */
    public function createPayment(Request $req)
    {
        $req->validate([
            'tagihan_id' => 'required|integer|exists:tagihan_pajaks,id',
            'metode' => 'nullable|string'
        ]);

        $user = $req->user();
        $tagihan = TagihanPajak::findOrFail($req->tagihan_id);

        $payment = DB::transaction(function () use ($tagihan, $user) {
            $kode = 'INV-'.date('Ymd').'-'.Str::upper(Str::random(8));
            $p = Pembayaran::create([
                'tagihan_pajak_id' => $tagihan->id,
                'user_id' => $user->id,
                'jumlah_bayar' => $tagihan->jumlah_tagihan,
                'kode_billing' => $kode,
                'status' => 'PENDING'
            ]);
            $tagihan->update(['status' => 'PAYMENT_INITIATED']);
            return $p;
        });

        // return payment page url (local simulate)
        $payment_page = route('payment.page', ['kode' => $payment->kode_billing]);

        return redirect($payment_page)->with('success', 'Pembayaran dibuat, menuju halaman pembayaran.');
    }

    /**
     * Payment page (simulate gateway)
     */
    public function paymentPage($kode)
    {
        $payment = Pembayaran::where('kode_billing', $kode)->firstOrFail();
        return view('payments.page', compact('payment'));
    }

    /**
     * Simulate gateway payment (local)
     */
    public function simulateGatewayPay($kode)
    {
        $payment = Pembayaran::where('kode_billing', $kode)->firstOrFail();

        if ($payment->status === 'SUCCESS') {
            return redirect()->route('payment.page', ['kode' => $kode])->with('info', 'Sudah dibayar.');
        }

        $payment->update([
            'status' => 'SUCCESS',
            'trx_id' => 'TRX'.time(),
            'paid_at' => now(),
        ]);

        // update related tagihan
        $payment->tagihan()->update(['status' => 'LUNAS']);

        // dispatch reconcile job if you have it (optional)
        if (class_exists(\App\Jobs\ReconcilePaymentJob::class)) {
            \App\Jobs\ReconcilePaymentJob::dispatch($payment);
        }

        return redirect()->route('payment.page', ['kode' => $kode])->with('success', 'Pembayaran berhasil (simulasi).');
    }
}
