<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        // ambil bulan & tahun dari request
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // filter history berdasarkan bulan & tahun
        $data = History::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $pemasukan = $data->where('aksi', 'simpan')->sum('jumlah');
        $pengeluaran = $data->where('aksi', 'ambil')->sum('jumlah');

        $selisih = $pemasukan - $pengeluaran;

        return view('rekap.index', compact(
            'data',
            'bulan',
            'tahun',
            'pemasukan',
            'pengeluaran',
            'selisih'
        ));
    }
}
