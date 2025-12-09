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
        $request->validate([
            'jenis' => 'required|in:tanah,bangunan,kendaraan,usaha',
            'alamat_objek' => 'required|string|max:500',
            'luas' => 'required|numeric|min:1',
            'njop' => 'required|numeric|min:1',
        ]);

        // Get current user's wajib pajak data
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        $wajibPajak = WajibPajak::where('user_id', $user->id)->first();
        
        if (!$wajibPajak) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mendaftar sebagai Wajib Pajak terlebih dahulu');
        }

        ObjekPajak::create([
            'wajib_pajak_id' => $wajibPajak->id,
            'jenis' => $request->jenis,
            'alamat_objek' => $request->alamat_objek,
            'nilai_objek' => $request->njop,
        ]);

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
