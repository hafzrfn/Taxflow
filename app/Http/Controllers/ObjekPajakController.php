<?php

namespace App\Http\Controllers;

use App\Models\ObjekPajak;
use App\Models\WajibPajak;
use Illuminate\Http\Request;

class ObjekPajakController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get current user's wajib pajak data
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $wajibPajak = WajibPajak::where('user_id', $user->id)->first();

        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        return view('user.objek-pajak.create', compact('wajibPajak'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation
        $rules = [
            'jenis' => 'required|in:tanah,bangunan,kendaraan,usaha',
        ];

        // Conditional validation based on jenis
        if ($request->jenis === 'kendaraan') {
            $rules['jenis_kendaraan'] = 'required|string|max:100';
            $rules['plat_nomor'] = 'required|string|max:20';
            $rules['stnk'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'; // max 5MB
            $rules['njop'] = 'required|numeric|min:1';
        } elseif ($request->jenis === 'usaha') {
            $rules['nama_bisnis'] = 'required|string|max:255';
            $rules['jenis_bisnis'] = 'required|string|max:100';
            $rules['alamat_objek'] = 'required|string|max:500';
            $rules['dokumen_usaha'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'; // max 5MB
            $rules['njop'] = 'required|numeric|min:1';
        } else {
            // For tanah and bangunan
            $rules['alamat_objek'] = 'required|string|max:500';
            $rules['luas'] = 'required|numeric|min:1';
            $rules['njop'] = 'required|numeric|min:1';
        }

        $request->validate($rules);

        // Get current user's wajib pajak data
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $wajibPajak = WajibPajak::where('user_id', $user->id)->first();

        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        // Prepare data for creation
        $data = [
            'wajib_pajak_id' => $wajibPajak->id,
            'jenis' => $request->jenis,
            'nilai_objek' => $request->njop,
        ];

        // Handle vehicle-specific fields
        if ($request->jenis === 'kendaraan') {
            $data['jenis_kendaraan'] = $request->jenis_kendaraan;
            $data['plat_nomor'] = $request->plat_nomor;

            // Upload STNK file
            if ($request->hasFile('stnk')) {
                $stnkPath = $request->file('stnk')->store('objek_pajak_documents/stnk', 'public');
                $data['stnk_path'] = $stnkPath;
            }
        }

        // Handle business-specific fields
        if ($request->jenis === 'usaha') {
            $data['nama_bisnis'] = $request->nama_bisnis;
            $data['jenis_bisnis'] = $request->jenis_bisnis;
            $data['alamat_objek'] = $request->alamat_objek;

            // Upload business document
            if ($request->hasFile('dokumen_usaha')) {
                $dokumenPath = $request->file('dokumen_usaha')->store('objek_pajak_documents/usaha', 'public');
                $data['dokumen_usaha_path'] = $dokumenPath;
            }
        }

        // Handle tanah/bangunan fields
        if (in_array($request->jenis, ['tanah', 'bangunan'])) {
            $data['alamat_objek'] = $request->alamat_objek;
        }

        ObjekPajak::create($data);

        return redirect()->route('dashboard')->with('success', 'Objek Pajak berhasil ditambahkan');
    }

    /**
     * Display a listing of user's objek pajak.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $wajibPajak = WajibPajak::where('user_id', $user->id)->first();

        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        $objekPajaks = $wajibPajak->objekPajaks;
        return view('user.objek-pajak.index', compact('objekPajaks', 'wajibPajak'));
    }
}
