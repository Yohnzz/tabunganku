<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListPembelian;
use App\Models\Tabungan;
use App\Models\History;
use Illuminate\Http\Request;

class ListPembelianController extends Controller
{
    public function index()
    {
        $items = ListPembelian::orderBy('prioritas')->get();
        
        // Data cashflow untuk grafik
        $rawCashflow = Tabungan::selectRaw('
    EXTRACT(MONTH FROM created_at) as bulan,
    SUM(CASE WHEN type = \'simpan\' THEN jumlah ELSE 0 END) as pemasukan,
    SUM(CASE WHEN type = \'ambil\' THEN jumlah ELSE 0 END) as pengeluaran
')
->whereYear('created_at', date('Y'))
->groupBy('bulan')
->get()
->keyBy('bulan');

        // Siapkan data 12 bulan
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $cashflowLabels = [];
        $cashflowPemasukan = [];
        $cashflowPengeluaran = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $cashflowLabels[] = $namaBulan[$i - 1];
            $cashflowPemasukan[] = isset($rawCashflow[$i]) ? $rawCashflow[$i]->pemasukan : 0;
            $cashflowPengeluaran[] = isset($rawCashflow[$i]) ? $rawCashflow[$i]->pengeluaran : 0;
        }

        $prioritasWajib = $items
            ->where('prioritas', 1)
            ->where('dibeli', false)
            ->count();

        $totalSimpan = Tabungan::where('type', 'simpan')->sum('jumlah');
        $totalAmbil  = Tabungan::where('type', 'ambil')->sum('jumlah');
        $saldo = $totalSimpan - $totalAmbil;

        $pemasukan = $totalSimpan;
        $pengeluaran = $totalAmbil;

        return view('pembelian.index', compact(
            'items',
            'prioritasWajib',
            'saldo',
            'pemasukan',
            'pengeluaran',
            'cashflowLabels',
            'cashflowPemasukan',
            'cashflowPengeluaran'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric|min:1',
            'prioritas' => 'required|numeric|min:1'
        ]);

        ListPembelian::create($request->all());

        return back()->with('success', 'Barang ditambahkan');
    }

    public function beli($id)
    {
        $item = ListPembelian::findOrFail($id);

        if ($item->dibeli) {
            return back()->with('error', 'Barang sudah dibeli');
        }

        $totalSimpan = Tabungan::where('type', 'simpan')->sum('jumlah');
        $totalAmbil  = Tabungan::where('type', 'ambil')->sum('jumlah');
        $saldo = $totalSimpan - $totalAmbil;

        if ($saldo < $item->harga) {
            return back()->with('error', 'Saldo tidak cukup');
        }

        // transaksi ambil
        Tabungan::create([
            'type' => 'ambil',
            'jumlah' => $item->harga,
            'keterangan' => 'Beli ' . $item->nama_barang
        ]);

        // history
        History::create([
            'aksi' => 'ambil',
            'jumlah' => $item->harga,
            'saldo_sebelum' => $saldo,
            'saldo_sesudah' => $saldo - $item->harga,
            'keterangan' => 'Beli ' . $item->nama_barang
        ]);

        // tandai dibeli
        $item->update(['dibeli' => true]);

        return back()->with('success', 'Barang berhasil dibeli');
    }
}