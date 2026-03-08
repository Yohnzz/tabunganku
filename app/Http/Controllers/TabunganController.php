<?php
namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;

class TabunganController extends Controller
{
    public function index()
{
    $data = Tabungan::latest()->get();
    $histories = History::latest()->get();

    $totalSimpan = Tabungan::where('type', 'simpan')->sum('jumlah');
    $totalAmbil  = Tabungan::where('type', 'ambil')->sum('jumlah');

    $saldo = $totalSimpan - $totalAmbil;

    return view('index', compact(
        'data',
        'histories',
        'totalSimpan',
        'totalAmbil',
        'saldo'
    ));
}

    public function store(Request $request)
{
    $request->validate([
        'type' => 'required',
        'jumlah' => 'required|numeric|min:1'
    ]);

    $totalSimpan = Tabungan::where('type', 'simpan')->sum('jumlah');
    $totalAmbil  = Tabungan::where('type', 'ambil')->sum('jumlah');

    $saldoSebelum = $totalSimpan - $totalAmbil;

    // simpan transaksi
    Tabungan::create([
        'type' => $request->type,
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan
    ]);

    // hitung saldo baru
    if ($request->type == 'simpan') {
        $saldoSesudah = $saldoSebelum + $request->jumlah;
    } else {
        $saldoSesudah = $saldoSebelum - $request->jumlah;
    }

    // simpan history
    History::create([
        'aksi' => $request->type,
        'jumlah' => $request->jumlah,
        'saldo_sebelum' => $saldoSebelum,
        'saldo_sesudah' => $saldoSesudah,
        'keterangan' => $request->keterangan
    ]);

    return redirect()->back()->with('success', 'Transaksi & history berhasil disimpan!');
}

}
