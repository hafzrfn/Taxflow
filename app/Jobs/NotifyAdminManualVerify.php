<?php
namespace App\Jobs;

use App\Models\WajibPajak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyAdminManualVerify implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $wajibPajak;

    public function __construct(WajibPajak $wajibPajak)
    {
        $this->wajibPajak = $wajibPajak;
    }

    public function handle()
    {
        // For demo: write log or send email to admin group
        \Log::info('Manual verify requested for WajibPajak: '.$this->wajibPajak->id);
        // TODO: send Notification::route('mail', 'admin@example.com')->notify(new ManualVerifyNotification($this->wajibPajak));
    }
}
