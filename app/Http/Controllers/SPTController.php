<?php

namespace App\Http\Controllers;

use App\Http\Requests\SPTRequest;
use App\Models\SPT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class SPTController extends Controller
{
    public function submit(SPTRequest $request)
    {
        $data = $request->validated();

        // simpan file attachments jika ada
        $filePaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('spt_attachments', 'public');
                $filePaths[] = $path;
            }
        }

        // create SPT record
        $spt = DB::transaction(function () use ($data, $filePaths) {
            $spt = SPT::create([
                'wajib_pajak_id' => auth()->user()->wajibPajak->id,
                'tahun_pajak' => $data['tahun_pajak'],
                'penghasilan' => $data['penghasilan'],
                'jenis_spt' => $data['jenis_spt'],
                'status_verifikasi' => 'PENDING',
                'receipt_id' => 'RCPT-' . time() . '-' . substr(md5(uniqid()), 0, 8),
                // tambahkan kolom lain jika ada
            ]);

            // Log audit (pastikan AuditLog model fillable berisi actor/action/payload)
            AuditLog::create([
                'actor' => auth()->id(),
                'action' => 'submit_spt',
                'payload' => json_encode(['spt_id' => $spt->id, 'files' => $filePaths]),
            ]);

            return $spt;
        });

        // Redirect ke dashboard atau detail SPT dengan flash message
        return redirect()->route('dashboard')
                         ->with('success', 'SPT submitted successfully')
                         ->with('spt_id', $spt->id)
                         ->with('receipt_id', $spt->receipt_id);
    }
}
