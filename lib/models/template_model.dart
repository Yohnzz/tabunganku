class TemplateModel {
  final int id;
  final int nominal;
  final String keterangan;

  TemplateModel({
    required this.id,
    required this.nominal,
    required this.keterangan,
  });

  // Untuk mengubah JSON dari API/Supabase menjadi Object Flutter
  factory TemplateModel.fromJson(Map<String, dynamic> json) {
    return TemplateModel(
      id: json['id'],
      nominal: json['nominal'] ?? 0,
      keterangan: json['keterangan'] ?? '',
    );
  }
}