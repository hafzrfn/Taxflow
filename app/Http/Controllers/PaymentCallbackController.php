<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class PaymentCallbackController extends Controller
{
    // expected JSON: { kode_billing, status, trx_id, amount, signature }
    public function handle(Request $req)
    {
        $payload = $req->all();
        // verify signature
        $verifier = app(\App\Services\PaymentGateway\PaymentGatewayVerifier::class);
        if (! $verifier->verify($req->header('X-Signature'), $payload)) {
            AuditLog::create(['actor'=>'gateway','action'=>'callback_invalid_signature','payload'=>json_encode($payload)]);
            return response()->json(['message'=>'Invalid signature'], 403);
        }

        $kode = $payload['kode_billing'] ?? null;
        if (! $kode) {
            return response()->json(['message'=>'kode_billing required'], 400);
        }

        $payment = Pembayaran::where('kode_billing',$kode)->first();
        if (! $payment) {
            AuditLog::create(['actor'=>'gateway','action'=>'callback_unknown_payment','payload'=>json_encode($payload)]);
            return response()->json(['message'=>'payment not found'], 404);
        }

        // idempotent: if already success, return OK
        if ($payment->status === 'SUCCESS') {
            return response()->json(['ok' => true], 200);
        }

        // validate amount if provided
        if (isset($payload['amount']) && (float)$payload['amount'] != (float)$payment->jumlah_bayar) {
            AuditLog::create(['actor'=>'gateway','action'=>'callback_amount_mismatch','payload'=>json_encode($payload)]);
            // choose to reject or mark as failed
            return response()->json(['message'=>'amount mismatch'], 422);
        }

        if ($payload['status'] === 'SUCCESS') {
            DB::transaction(function () use ($payment, $payload) {
                $payment->update([
                    'status' => 'SUCCESS',
                    'trx_id' => $payload['trx_id'] ?? null,
                    'paid_at' => now(),
                ]);
                $payment->tagihan()->update(['status' => 'LUNAS']);
                AuditLog::create(['actor'=>'gateway','action'=>'callback_processed','payload'=>json_encode($payload)]);
            });

            // dispatch reconcile job
            \App\Jobs\ReconcilePaymentJob::dispatch($payment);

            return response()->json(['ok' => true], 200);
        }

        // handle failed
        $payment->update([
            'status' => 'FAILED',
        ]);
        AuditLog::create(['actor'=>'gateway','action'=>'callback_failed','payload'=>json_encode($payload)]);
        return response()->json(['ok' => true], 200);
    }
}
