<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\WajibPajak;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\Dukcapil\DukcapilClientInterface;
use App\Jobs\NotifyAdminManualVerify;
use App\Models\AuditLog;

class RegistrationController extends Controller
{
    protected $duk;

    public function __construct(DukcapilClientInterface $duk)
    {
        $this->duk = $duk;
    }

    public function register(RegisterRequest $req)
    {
        $data = $req->validated();

        // call dukcapil
        $verify = $this->duk->verify($data['nik']);

        return DB::transaction(function () use ($data, $verify) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'user',
            ]);

            $status = $verify['success'] ? 'VERIFIED' : 'PENDING_VERIF';

            $wp = WajibPajak::create([
                'user_id' => $user->id,
                'nik' => $data['nik'],
                'no_hp' => $data['no_hp'] ?? null,
                'alamat' => $data['alamat'] ?? ($verify['data']['address'] ?? null),
                'status' => $status,
            ]);

            AuditLog::create([
                'actor' => 'system',
                'action' => 'register_wajib_pajak',
                'payload' => json_encode([
                    'user_id' => $user->id,
                    'wajib_pajak_id' => $wp->id,
                    'duk_response' => $verify
                ])
            ]);

            if (! $verify['success']) {
                // enqueue admin notification for manual verification
                NotifyAdminManualVerify::dispatch($wp);
            }

            // auto-login if you want:
            // auth()->login($user);

            return response()->json([
                'message' => $verify['success'] ? 'Registrasi berhasil dan terverifikasi' : 'Registrasi berhasil, menunggu verifikasi manual',
                'user_id' => $user->id,
                'wajib_pajak_id' => $wp->id,
            ], $verify['success'] ? 201 : 202);
        });
    }
}
