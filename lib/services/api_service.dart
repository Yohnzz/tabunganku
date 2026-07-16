import 'package:supabase_flutter/supabase_flutter.dart';
import '../models/tabungan_model.dart';
import '../models/template_model.dart';

class ApiService {
  final _supabase = Supabase.instance.client;

  // Mendapatkan ID user yang sedang login
  String get _userId => _supabase.auth.currentUser!.id;

  // 1. Ambil semua data tabungan (Otomatis terfilter oleh RLS Supabase)
  Future<TabunganResponse> getTabunganData() async {
    try {
      final response = await _supabase
          .from('tabungans')
          .select()
          .order('created_at', ascending: false);

      final List<Tabungan> transaksi = (response as List)
          .map((item) => Tabungan.fromJson(item))
          .toList();

      // Hitung Total Secara Lokal (atau bisa via Query Supabase)
      int totalSimpan = 0;
      int totalAmbil = 0;
      Map<String, int> saldoLokasi = {'dompet': 0, 'celengan': 0, 'gopay': 0};

      for (var t in transaksi) {
        if (t.type == 'simpan') {
          totalSimpan += t.jumlah;
          saldoLokasi[t.lokasi] = (saldoLokasi[t.lokasi] ?? 0) + t.jumlah;
        } else {
          totalAmbil += t.jumlah;
          saldoLokasi[t.lokasi] = (saldoLokasi[t.lokasi] ?? 0) - t.jumlah;
        }
      }

      return TabunganResponse(
        transaksi: transaksi,
        totalSimpan: totalSimpan,
        totalAmbil: totalAmbil,
        saldo: totalSimpan - totalAmbil,
        saldoLokasi: saldoLokasi,
      );
    } catch (e) {
      throw Exception("Gagal memuat data: $e");
    }
  }

  // 2. Tambah Transaksi Baru
  Future<bool> postTabungan(String type, String lokasi, int jumlah, String keterangan) async {
    try {
      await _supabase.from('tabungans').insert({
        'user_id': _userId, // Set user_id pemilik data
        'type': type,
        'lokasi': lokasi,
        'jumlah': jumlah,
        'keterangan': keterangan,
      });
      return true;
    } catch (e) {
      return false;
    }
  }

  // 3. Update Transaksi
  Future<bool> updateTabungan(int id, String type, String lokasi, int jumlah, String keterangan) async {
    try {
      await _supabase.from('tabungans').update({
        'type': type,
        'lokasi': lokasi,
        'jumlah': jumlah,
        'keterangan': keterangan,
      }).eq('id', id);
      return true;
    } catch (e) {
      return false;
    }
  }

  // 4. Hapus Transaksi
  Future<bool> deleteTabungan(int id) async {
    try {
      await _supabase.from('tabungans').delete().eq('id', id);
      return true;
    } catch (e) {
      return false;
    }
  }

  // 5. Transfer Saldo
  Future<bool> postTransfer(String from, String to, int nominal) async {
    try {
      // Transfer adalah 2 transaksi sekaligus (Ambil dari asal, Simpan ke tujuan)
      await _supabase.from('tabungans').insert([
        {
          'user_id': _userId,
          'type': 'ambil',
          'lokasi': from,
          'jumlah': nominal,
          'keterangan': 'Transfer ke $to',
        },
        {
          'user_id': _userId,
          'type': 'simpan',
          'lokasi': to,
          'jumlah': nominal,
          'keterangan': 'Transfer dari $from',
        }
      ]);
      return true;
    } catch (e) {
      return false;
    }
  }

  // --- TEMPLATE LOGIC ---

  Future<List<TemplateModel>> getTemplates() async {
    try {
      final response = await _supabase.from('templates').select();
      return (response as List).map((e) => TemplateModel.fromJson(e)).toList();
    } catch (e) {
      return [];
    }
  }

  Future<bool> postNewTemplate(int nominal, String keterangan) async {
    try {
      await _supabase.from('templates').insert({
        'user_id': _userId,
        'nominal': nominal,
        'keterangan': keterangan,
      });
      return true;
    } catch (e) {
      return false;
    }
  }

  Future<bool> deleteTemplate(int id) async {
    try {
      await _supabase.from('templates').delete().eq('id', id);
      return true;
    } catch (e) {
      return false;
    }
  }
}
