<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WajibPajak;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\Dukcapil\DukcapilClientInterface;

class RegisteredUserController extends Controller
{
    protected $duk;

    public function __construct(DukcapilClientInterface $duk)
    {
        $this->duk = $duk;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => 'required|string|digits:16|unique:wajib_pajaks,nik',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Verify NIK with Dukcapil service
            $verify = $this->duk->verify($request->nik);
            $status = $verify['success'] ? 'VERIFIED' : 'PENDING_VERIF';

            // Create WajibPajak with registration data
            WajibPajak::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'no_hp' => $request->no_hp ?? null,
                'alamat' => $request->alamat ?? ($verify['data']['address'] ?? null),
                'status' => $status,
            ]);

            event(new Registered($user));

            // Re-fetch user with WajibPajak relationship loaded
            $user = User::with('wajibPajak')->find($user->id);
            Auth::login($user);

            return redirect(route('dashboard', absolute: false))->with('success', 'Registrasi berhasil. ' . ($verify['success'] ? 'Terverifikasi.' : 'Menunggu verifikasi.'));
        });
    }
}
