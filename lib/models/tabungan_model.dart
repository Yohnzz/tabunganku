class TabunganResponse {
  final List<Tabungan> transaksi;
  final int totalSimpan;
  final int totalAmbil;
  final int saldo;
  final Map<String, int> saldoLokasi;

  TabunganResponse({
    required this.transaksi,
    required this.totalSimpan,
    required this.totalAmbil,
    required this.saldo,
    required this.saldoLokasi,
  });

  factory TabunganResponse.fromJson(Map<String, dynamic> json) {
    return TabunganResponse(
      transaksi: (json['transaksi'] as List)
          .map((i) => Tabungan.fromJson(i))
          .toList(),
      totalSimpan: json['total_simpan'],
      totalAmbil: json['total_ambil'],
      saldo: json['saldo'],
      saldoLokasi: Map<String, int>.from(json['saldo_lokasi']),
    );
  }
}

class Tabungan {
  final int id;
  final String type;
  final String lokasi;
  final int jumlah;
  final String keterangan;
  final DateTime createdAt;

  Tabungan({
    required this.id,
    required this.type,
    required this.lokasi,
    required this.jumlah,
    required this.keterangan,
    required this.createdAt,
  });

  factory Tabungan.fromJson(Map<String, dynamic> json) {
    return Tabungan(
      id: json['id'],
      type: json['type'],
      lokasi: json['lokasi'],
      jumlah: json['jumlah'],
      keterangan: json['keterangan'] ?? '-',
      createdAt: DateTime.parse(json['created_at']),
    );
  }
}