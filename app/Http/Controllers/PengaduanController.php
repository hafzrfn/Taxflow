<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function store(Request $req)
    {
        $req->validate(['judul'=>'required','isi'=>'required']);
        $user = $req->user();
        $peng = Pengaduan::create([
            'wajib_pajak_id' => $user->wajibPajak->id,
            'judul' => $req->judul,
            'isi' => $req->isi,
            'status' => 'PENDING'
        ]);
        return redirect()->back()->with('success','Pengaduan terkirim');
    }

    public function indexAdmin()
    {
        $all = Pengaduan::latest()->paginate(20);
        return view('admin.pengaduan.index', compact('all'));
    }

    public function respond(Request $req, Pengaduan $pengaduan)
    {
        $req->validate(['status'=>'required','response'=>'nullable']);
        $pengaduan->update(['status'=>$req->status]);
        // optionally record response in another table or send notification
        return redirect()->back()->with('success','Pengaduan diupdate');
    }
}

//DISCONTINUED