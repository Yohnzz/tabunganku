import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class LokasiCard extends StatelessWidget {
  final String nama;
  final int saldo;
  final Color color1;
  final Color color2;
  final String emoji;

  const LokasiCard({
    super.key,
    required this.nama,
    required this.saldo,
    required this.color1,
    required this.color2,
    required this.emoji
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      // Kurangi padding agar area konten lebih luas
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 12),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          colors: [color1, color2],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: color1.withValues(alpha: 0.3),
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(emoji, style: const TextStyle(fontSize: 20)),
          const SizedBox(height: 4),
          Text(
              nama,
              style: const TextStyle(
                  color: Colors.white70,
                  fontSize: 11,
                  fontWeight: FontWeight.w600
              )
          ),
          const SizedBox(height: 2),
          // --- BAGIAN KUNCI RESPONSIF ---
          FittedBox(
            fit: BoxFit.scaleDown, // Teks akan mengecil otomatis jika kepanjangan
            child: Text(
              NumberFormat.currency(locale: 'id', symbol: 'Rp', decimalDigits: 0).format(saldo),
              style: const TextStyle(
                  color: Colors.white,
                  fontSize: 14, // Ukuran ideal
                  fontWeight: FontWeight.bold
              ),
            ),
          ),
        ],
      ),
    );
  }
}