<?php
namespace App\Jobs;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReconcilePaymentJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $payment;

    public function __construct(Pembayaran $payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        // Example: send payment to external accounting system (SIKeu)
        // Wrap in try/catch and implement retry/backoff via queue config
        try {
            \Log::info('Reconciling payment id '.$this->payment->id);
            // e.g. Http::post(config('services.sikeu.endpoint'), [...])
            // If success update reconciled flag:
            $this->payment->update(['reconciled' => true, 'reconciled_at' => now()]);
        } catch (\Throwable $e) {
            \Log::error('Reconcile failed: '.$e->getMessage());
            // Throw to allow job retry if configured
            throw $e;
        }
    }
}
