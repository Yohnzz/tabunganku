import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/tabungan_model.dart';
import 'package:intl/intl.dart';

class HistoryDetailPage extends StatefulWidget {
  final Map<String, int> saldoLokasi;
  const HistoryDetailPage({super.key, required this.saldoLokasi});

  @override
  State<HistoryDetailPage> createState() => _HistoryDetailPageState();
}

class _HistoryDetailPageState extends State<HistoryDetailPage> {
  final ApiService _api = ApiService();
  String _selectedFilter = 'Semua';
  String _searchQuery = '';
  final TextEditingController _searchController = TextEditingController();

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final formatter = NumberFormat.decimalPattern('id');

    return Scaffold(
      backgroundColor: const Color(0xFFF8F9FD),
      appBar: AppBar(
        title: const Text("Riwayat Lengkap", style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF4361EE),
        elevation: 0,
      ),
      body: Column(
        children: [
          // Header Pencarian & Filter
          Container(
            color: Colors.white,
            padding: const EdgeInsets.all(16),
            child: Column(
              children: [
                TextField(
                  controller: _searchController,
                  onChanged: (val) => setState(() => _searchQuery = val),
                  decoration: InputDecoration(
                    hintText: "Cari keterangan...",
                    prefixIcon: const Icon(Icons.search),
                    filled: true,
                    fillColor: Colors.grey[100],
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide.none),
                  ),
                ),
                const SizedBox(height: 12),
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: ['Semua', 'Dompet', 'Celengan', 'GoPay'].map((filter) {
                      bool isSelected = _selectedFilter == filter;
                      return Padding(
                        padding: const EdgeInsets.only(right: 8),
                        child: FilterChip(
                          selected: isSelected,
                          label: Text(filter),
                          onSelected: (val) => setState(() => _selectedFilter = filter),
                          selectedColor: const Color(0xFF4361EE).withValues(alpha: 0.2),
                          checkmarkColor: const Color(0xFF4361EE),
                        ),
                      );
                    }).toList(),
                  ),
                ),
              ],
            ),
          ),

          // Daftar Transaksi
          Expanded(
            child: FutureBuilder<TabunganResponse>(
              future: _api.getTabunganData(),
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }

                if (snapshot.hasError || !snapshot.hasData) {
                  return const Center(child: Text("Gagal memuat riwayat"));
                }

                final allData = snapshot.data!.transaksi;
                final filtered = allData.where((t) {
                  final matchLokasi = _selectedFilter == 'Semua' || t.lokasi.toLowerCase() == _selectedFilter.toLowerCase();
                  final matchSearch = t.keterangan.toLowerCase().contains(_searchQuery.toLowerCase());
                  return matchLokasi && matchSearch;
                }).toList();

                if (filtered.isEmpty) {
                  return const Center(child: Text("Tidak ada transaksi ditemukan"));
                }

                return ListView.builder(
                  padding: const EdgeInsets.all(16),
                  itemCount: filtered.length,
                  itemBuilder: (context, index) {
                    final item = filtered[index];
                    return _buildHistoryItem(item, formatter);
                  },
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHistoryItem(Tabungan item, NumberFormat formatter) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.03), blurRadius: 10, offset: const Offset(0, 4))],
      ),
      child: ListTile(
        leading: Icon(
          item.type == 'simpan' ? Icons.add_circle : Icons.remove_circle,
          color: item.type == 'simpan' ? Colors.green : Colors.red,
        ),
        title: Text(item.keterangan.isEmpty ? "Tanpa Keterangan" : item.keterangan, style: const TextStyle(fontWeight: FontWeight.bold)),
        subtitle: Text("${item.lokasi.toUpperCase()} • ${DateFormat('dd MMM yyyy, HH:mm').format(item.createdAt)}"),
        trailing: Text(
          "${item.type == 'simpan' ? '+' : '-'} Rp ${formatter.format(item.jumlah)}",
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: item.type == 'simpan' ? Colors.green[700] : Colors.red[700],
          ),
        ),
      ),
    );
  }
}
