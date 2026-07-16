import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../models/tabungan_model.dart';
import '../widgets/balance_card.dart';
import '../widgets/lokasi_card.dart';
import '../../models/template_model.dart';
import 'package:intl/intl.dart';
import 'package:flutter/services.dart';
import 'package:home_widget/home_widget.dart';
import 'package:provider/provider.dart';
import '../../providers/auth_provider.dart';
import '../../pages/auth/login_page.dart';
import 'history_page.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});
  @override
  State<HomePage> createState() => _HomePageState();
}

Widget _buildModernSelectCard({required String title, required String emoji, required bool isSelected, required Color activeColor, required VoidCallback onTap}) {
  return Expanded(
    child: InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(16),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 300),
        padding: const EdgeInsets.symmetric(vertical: 16),
        decoration: BoxDecoration(
          color: isSelected ? activeColor : Colors.white,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: isSelected ? activeColor : Colors.grey[200]!),
          boxShadow: isSelected ? [BoxShadow(color: activeColor.withValues(alpha: 0.3), blurRadius: 8, offset: const Offset(0, 4))] : [],
        ),
        child: Column(
          children: [
            Text(emoji, style: const TextStyle(fontSize: 24)),
            const SizedBox(height: 8),
            Text(title, style: TextStyle(fontWeight: FontWeight.bold, color: isSelected ? Colors.white : Colors.black87)),
          ],
        ),
      ),
    ),
  );
}

Widget _buildModernSmallCard({required String title, required String emoji, required String saldo, required bool isSelected, required Color color, required VoidCallback onTap}) {
  return Expanded(
    child: InkWell(
      onTap: onTap,
      child: Container(
        margin: const EdgeInsets.symmetric(horizontal: 4),
        padding: const EdgeInsets.symmetric(vertical: 12),
        decoration: BoxDecoration(
          color: isSelected ? color.withValues(alpha: 0.1) : Colors.transparent,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: isSelected ? color : Colors.grey[200]!, width: 1.5),
        ),
        child: Column(
          children: [
            Text(emoji, style: const TextStyle(fontSize: 20)),
            const SizedBox(height: 4),
            Text(title, style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: isSelected ? color : Colors.black54)),
            Text(saldo, style: TextStyle(fontSize: 9, color: isSelected ? color : Colors.grey[500])),
          ],
        ),
      ),
    ),
  );
}

class _HomePageState extends State<HomePage> {
  final ApiService _api = ApiService();
  String _selectedFilter = 'Semua';
  String _searchQuery = ''; // ✅ State untuk pencarian
  final TextEditingController _searchController = TextEditingController();
  DateTime? _lastPressedAt;

  @override
  void initState() {
    super.initState();
    HomeWidget.setAppGroupId('group.tabunganku');
  }

  void _updateWidget(Map<String, int> saldoLokasi) {
    final formatter = NumberFormat.decimalPattern('id');
    HomeWidget.saveWidgetData('dompet', "Rp ${formatter.format(saldoLokasi['dompet'] ?? 0)}");
    HomeWidget.saveWidgetData('celengan', "Rp ${formatter.format(saldoLokasi['celengan'] ?? 0)}");
    HomeWidget.saveWidgetData('gopay', "Rp ${formatter.format(saldoLokasi['gopay'] ?? 0)}");
    HomeWidget.updateWidget(
      name: 'BalanceWidgetProvider',
      androidName: 'BalanceWidgetProvider',
    );
  }

  void _showFormTabungan(BuildContext context, Map<String, int> saldoLokasi, {Tabungan? existingTabungan}) {
    final TextEditingController jumlahController = TextEditingController();
    final TextEditingController ketController = TextEditingController();
    final formatter = NumberFormat.decimalPattern('id');

    if (existingTabungan != null) {
      jumlahController.text = formatter.format(existingTabungan.jumlah);
      ketController.text = existingTabungan.keterangan;
    }

    String selectedType = existingTabungan?.type ?? 'simpan';
    String selectedLokasi = existingTabungan?.lokasi ?? 'dompet';
    bool isSaveAsTemplate = false;

    Future<List<TemplateModel>> templateFuture = _api.getTemplates();

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return StatefulBuilder(builder: (context, setModalState) {
          return Container(
            padding: EdgeInsets.only(
                bottom: MediaQuery.of(context).viewInsets.bottom + 24,
                left: 24, right: 24, top: 12),
            decoration: const BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.vertical(top: Radius.circular(32)),
            ),
            child: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Center(
                    child: Container(
                        width: 40, height: 4,
                        margin: const EdgeInsets.only(bottom: 20),
                        decoration: BoxDecoration(color: Colors.grey[300], borderRadius: BorderRadius.circular(10))),
                  ),

                  const Text("Tambah Transaksi", style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 20),

                  Row(
                    children: [
                      _buildModernSelectCard(
                        title: "Simpan", emoji: "💰",
                        isSelected: selectedType == 'simpan',
                        activeColor: const Color(0xFF4361EE),
                        onTap: () => setModalState(() => selectedType = 'simpan'),
                      ),
                      const SizedBox(width: 12),
                      _buildModernSelectCard(
                        title: "Ambil", emoji: "💸",
                        isSelected: selectedType == 'ambil',
                        activeColor: const Color(0xFFF72585),
                        onTap: () => setModalState(() => selectedType = 'ambil'),
                      ),
                    ],
                  ),

                  const SizedBox(height: 24),

                  const Text("Template Cepat", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.black54)),
                  const SizedBox(height: 12),

                  FutureBuilder<List<TemplateModel>>(
                    future: templateFuture,
                    builder: (context, snapshot) {
                      if (snapshot.connectionState == ConnectionState.waiting) {
                        return const SizedBox(height: 4, child: LinearProgressIndicator());
                      }
                      final dbTemplates = snapshot.data ?? [];
                      if (dbTemplates.isEmpty) {
                        return const Padding(
                          padding: EdgeInsets.only(bottom: 4),
                          child: Text("Belum ada template", style: TextStyle(fontSize: 12, color: Colors.grey)),
                        );
                      }
                      return Wrap(
                        spacing: 8,
                        runSpacing: 8,
                        children: dbTemplates.map((t) {
                          return InputChip(
                            backgroundColor: const Color(0xFF4361EE).withValues(alpha: 0.08),
                            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8), side: BorderSide(color: const Color(0xFF4361EE).withValues(alpha: 0.3))),
                            label: Text(
                              t.keterangan.isNotEmpty
                                  ? "${t.keterangan} • Rp ${formatter.format(t.nominal)}"
                                  : "Rp ${formatter.format(t.nominal)}",
                              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: Color(0xFF4361EE)),
                            ),
                            onPressed: () {
                              setModalState(() {
                                jumlahController.text = formatter.format(t.nominal);
                                if (t.keterangan.isNotEmpty) {
                                  ketController.text = t.keterangan;
                                }
                              });
                            },
                            deleteIcon: const Icon(Icons.cancel, size: 18, color: Colors.redAccent),
                            onDeleted: () async {
                              bool success = await _api.deleteTemplate(t.id);
                              if (success) {
                                setModalState(() {
                                  templateFuture = _api.getTemplates();
                                });
                              }
                            },
                          );
                        }).toList(),
                      );
                    },
                  ),

                  const SizedBox(height: 20),

                  Row(
                    children: [
                      _buildModernSmallCard(
                        title: "Dompet", emoji: "👛",
                        saldo: "Rp ${formatter.format(saldoLokasi['dompet'] ?? 0)}",
                        isSelected: selectedLokasi == 'dompet',
                        color: const Color(0xFF4361EE),
                        onTap: () => setModalState(() => selectedLokasi = 'dompet'),
                      ),
                      _buildModernSmallCard(
                        title: "Celengan", emoji: "🐷",
                        saldo: "Rp ${formatter.format(saldoLokasi['celengan'] ?? 0)}",
                        isSelected: selectedLokasi == 'celengan',
                        color: const Color(0xFFFF9E00),
                        onTap: () => setModalState(() => selectedLokasi = 'celengan'),
                      ),
                      _buildModernSmallCard(
                        title: "GoPay", emoji: "📱",
                        saldo: "Rp ${formatter.format(saldoLokasi['gopay'] ?? 0)}",
                        isSelected: selectedLokasi == 'gopay',
                        color: const Color(0xFF4CC9F0),
                        onTap: () => setModalState(() => selectedLokasi = 'gopay'),
                      ),
                    ],
                  ),

                  const SizedBox(height: 28),

                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    decoration: BoxDecoration(color: Colors.grey[100], borderRadius: BorderRadius.circular(16)),
                    child: TextField(
                      controller: jumlahController,
                      keyboardType: TextInputType.number,
                      style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Color(0xFF4361EE)),
                      inputFormatters: [
                        FilteringTextInputFormatter.digitsOnly,
                        CurrencyInputFormatter(),
                        LengthLimitingTextInputFormatter(10),
                      ],
                      decoration: const InputDecoration(
                        label: Text("Nominal Transaksi"),
                        prefixText: "Rp ",
                        border: InputBorder.none,
                        hintText: "0",
                      ),
                    ),
                  ),

                  const SizedBox(height: 16),

                  TextField(
                    controller: ketController,
                    decoration: InputDecoration(
                      labelText: "Keterangan",
                      hintText: "Mau buat apa?",
                      prefixIcon: const Icon(Icons.edit_note),
                      filled: true,
                      fillColor: Colors.white,
                      enabledBorder: UnderlineInputBorder(borderSide: BorderSide(color: Colors.grey[300]!)),
                      focusedBorder: const UnderlineInputBorder(borderSide: BorderSide(color: Color(0xFF4361EE), width: 2)),
                    ),
                  ),

                  const SizedBox(height: 16),

                  Row(
                    children: [
                      Checkbox(
                        value: isSaveAsTemplate,
                        activeColor: const Color(0xFF4361EE),
                        onChanged: (val) => setModalState(() => isSaveAsTemplate = val!),
                      ),
                      const Text("Simpan sebagai template", style: TextStyle(fontSize: 13)),
                    ],
                  ),

                  const SizedBox(height: 16),

                  SizedBox(
                    width: double.infinity,
                    height: 55,
                    child: ElevatedButton(
                      onPressed: () async {
                        String cleanValue = jumlahController.text.replaceAll('.', '');
                        if (cleanValue.isEmpty) return;
                        int nominal = int.parse(cleanValue);

                        if (nominal > 10000000) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            SnackBar(
                              content: const Text("❌ Maksimal transaksi Rp 10.000.000"),
                              behavior: SnackBarBehavior.floating,
                              backgroundColor: Colors.redAccent,
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                            ),
                          );
                          return;
                        }

                        try {
                          if (isSaveAsTemplate) {
                            await _api.postNewTemplate(nominal, ketController.text);
                          }
                          
                          bool success;
                          if (existingTabungan != null) {
                            success = await _api.updateTabungan(
                              existingTabungan.id,
                              selectedType,
                              selectedLokasi,
                              nominal,
                              ketController.text,
                            );
                          } else {
                            success = await _api.postTabungan(selectedType, selectedLokasi, nominal, ketController.text);
                          }

                          if (success) {
                            if (context.mounted) Navigator.pop(context);
                            setState(() {});
                          }
                        } catch (e) {
                          debugPrint("Gagal menyimpan: $e");
                        }
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF4361EE),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                        elevation: 8,
                        shadowColor: const Color(0xFF4361EE).withValues(alpha: 0.5),
                      ),
                      child: Text(
                        existingTabungan != null 
                            ? "Simpan Perubahan" 
                            : (selectedType == 'simpan' ? "Simpan Sekarang" : "Ambil Uang"),
                        style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.white),
                      ),
                    ),
                  ),
                  const SizedBox(height: 8),
                ],
              ),
            ),
          );
        });
      },
    );
  }

  void _showTransferForm(BuildContext context, Map<String, int> saldoLokasi) {
    final TextEditingController jumlahController = TextEditingController();
    final formatter = NumberFormat.decimalPattern('id');
    String fromLokasi = 'dompet';
    String toLokasi = 'celengan';

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => StatefulBuilder(
        builder: (context, setModalState) => Container(
          padding: EdgeInsets.only(bottom: MediaQuery.of(context).viewInsets.bottom + 24, left: 24, right: 24, top: 12),
          decoration: const BoxDecoration(color: Colors.white, borderRadius: BorderRadius.vertical(top: Radius.circular(32))),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisSize: MainAxisSize.min,
            children: [
              Center(child: Container(width: 40, height: 4, margin: const EdgeInsets.only(bottom: 20), decoration: BoxDecoration(color: Colors.grey[300], borderRadius: BorderRadius.circular(10)))),
              const Text("Transfer Saldo", style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
              const SizedBox(height: 24),
              
              const Text("Dari", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.black54)),
              const SizedBox(height: 8),
              Row(
                children: [
                  _buildModernSmallCard(title: "Dompet", emoji: "👛", saldo: "Rp ${formatter.format(saldoLokasi['dompet'] ?? 0)}", isSelected: fromLokasi == 'dompet', color: const Color(0xFF4361EE), onTap: () => setModalState(() => fromLokasi = 'dompet')),
                  _buildModernSmallCard(title: "Celengan", emoji: "🐷", saldo: "Rp ${formatter.format(saldoLokasi['celengan'] ?? 0)}", isSelected: fromLokasi == 'celengan', color: const Color(0xFFFF9E00), onTap: () => setModalState(() => fromLokasi = 'celengan')),
                  _buildModernSmallCard(title: "GoPay", emoji: "📱", saldo: "Rp ${formatter.format(saldoLokasi['gopay'] ?? 0)}", isSelected: fromLokasi == 'gopay', color: const Color(0xFF4CC9F0), onTap: () => setModalState(() => fromLokasi = 'gopay')),
                ],
              ),
              
              const Padding(
                padding: EdgeInsets.symmetric(vertical: 16),
                child: Center(child: Icon(Icons.arrow_downward_rounded, color: Color(0xFF4361EE))),
              ),
              
              const Text("Ke", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.black54)),
              const SizedBox(height: 8),
              Row(
                children: [
                  _buildModernSmallCard(title: "Dompet", emoji: "👛", saldo: "Rp ${formatter.format(saldoLokasi['dompet'] ?? 0)}", isSelected: toLokasi == 'dompet', color: const Color(0xFF4361EE), onTap: () => setModalState(() => toLokasi = 'dompet')),
                  _buildModernSmallCard(title: "Celengan", emoji: "🐷", saldo: "Rp ${formatter.format(saldoLokasi['celengan'] ?? 0)}", isSelected: toLokasi == 'celengan', color: const Color(0xFFFF9E00), onTap: () => setModalState(() => toLokasi = 'celengan')),
                  _buildModernSmallCard(title: "GoPay", emoji: "📱", saldo: "Rp ${formatter.format(saldoLokasi['gopay'] ?? 0)}", isSelected: toLokasi == 'gopay', color: const Color(0xFF4CC9F0), onTap: () => setModalState(() => toLokasi = 'gopay')),
                ],
              ),
              
              const SizedBox(height: 24),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                decoration: BoxDecoration(color: Colors.grey[100], borderRadius: BorderRadius.circular(16)),
                child: TextField(
                  controller: jumlahController,
                  keyboardType: TextInputType.number,
                  style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Color(0xFF4361EE)),
                  inputFormatters: [FilteringTextInputFormatter.digitsOnly, CurrencyInputFormatter()],
                  decoration: const InputDecoration(label: Text("Nominal Transfer"), prefixText: "Rp ", border: InputBorder.none),
                ),
              ),
              
              const SizedBox(height: 24),
              SizedBox(
                width: double.infinity, height: 55,
                child: ElevatedButton(
                  onPressed: () async {
                    String cleanValue = jumlahController.text.replaceAll('.', '');
                    if (cleanValue.isEmpty) return;
                    int nominal = int.parse(cleanValue);
                    
                    if (fromLokasi == toLokasi) {
                      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("❌ Lokasi asal dan tujuan tidak boleh sama")));
                      return;
                    }

                    if (nominal > (saldoLokasi[fromLokasi] ?? 0)) {
                      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text("❌ Saldo tidak mencukupi")));
                      return;
                    }

                    bool success = await _api.postTransfer(fromLokasi, toLokasi, nominal);
                    if (success) {
                      if (context.mounted) Navigator.pop(context);
                      setState(() {});
                    }
                  },
                  style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF4361EE), shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16))),
                  child: const Text("Konfirmasi Transfer", style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.white)),
                ),
              ),
              const SizedBox(height: 12),
            ],
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final formatter = NumberFormat.decimalPattern('id');
    return PopScope(
      canPop: false,
      onPopInvokedWithResult: (didPop, result) {
        if (didPop) return;
        final now = DateTime.now();
        if (_lastPressedAt == null || 
            now.difference(_lastPressedAt!) > const Duration(seconds: 2)) {
          _lastPressedAt = now;
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Row(
                children: [
                  const Icon(Icons.exit_to_app, color: Colors.white),
                  const SizedBox(width: 12),
                  const Text("Klik 1 kali lagi untuk keluar", style: TextStyle(fontWeight: FontWeight.w600)),
                ],
              ),
              backgroundColor: const Color(0xFF4361EE),
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              duration: const Duration(seconds: 2),
              margin: const EdgeInsets.all(20),
            ),
          );
          return;
        }
        SystemNavigator.pop();
      },
      child: Scaffold(
        backgroundColor: const Color(0xFFF8F9FD),
      appBar: AppBar(
        title: Row(
          children: [
            const Text("TabunganKu", style: TextStyle(fontWeight: FontWeight.w800, fontSize: 20)),
            const SizedBox(width: 8),
            Text("(V 1.0.2.0)", style: TextStyle(fontSize: 12, color: Colors.grey[500], fontWeight: FontWeight.normal)),
          ],
        ),
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF4361EE),
        elevation: 0,
        centerTitle: false,
        actions: [
          IconButton(
            onPressed: () async {
              final confirm = await showDialog<bool>(
                context: context,
                builder: (context) => AlertDialog(
                  title: const Text("Logout"),
                  content: const Text("Apakah Anda yakin ingin keluar?"),
                  actions: [
                    TextButton(onPressed: () => Navigator.pop(context, false), child: const Text("Batal")),
                    TextButton(
                      onPressed: () => Navigator.pop(context, true),
                      child: const Text("Logout", style: TextStyle(color: Colors.red)),
                    ),
                  ],
                ),
              );
              if (confirm == true) {
                if (context.mounted) {
                  await Provider.of<AuthProvider>(context, listen: false).logout();
                  if (context.mounted) {
                    Navigator.pushAndRemoveUntil(
                      context,
                      MaterialPageRoute(builder: (context) => const LoginPage()),
                      (route) => false,
                    );
                  }
                }
              }
            },
            icon: const Icon(Icons.logout_rounded, color: Colors.redAccent),
            tooltip: "Logout",
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: () async => setState(() {}),
        child: FutureBuilder<TabunganResponse>(
          future: _api.getTabunganData(),
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            }

            // ✅ Penanganan Error: Jika error, buat data dummy 0 agar UI tetap muncul
            TabunganResponse data;
            String? errorMessage;

            if (snapshot.hasError) {
              data = TabunganResponse(
                transaksi: [],
                totalSimpan: 0,
                totalAmbil: 0,
                saldo: 0,
                saldoLokasi: {'dompet': 0, 'celengan': 0, 'gopay': 0},
              );

              // Tentukan pesan error berdasarkan jenis error
              final error = snapshot.error.toString().toLowerCase();
              if (error.contains('socketexception') || 
                  error.contains('network') || 
                  error.contains('failed to host') ||
                  error.contains('xmlhttprequest')) {
                errorMessage = "Kondisi sinyal anda sedang tidak stabil";
              } else {
                errorMessage = "Server with database not found";
              }
            } else {
              data = snapshot.data!;
              _updateWidget(data.saldoLokasi);
            }
            
            // Filter Transaksi (Lokasi + Pencarian)
            final filteredTransaksi = data.transaksi.where((t) {
              final matchLokasi = _selectedFilter == 'Semua' || t.lokasi.toLowerCase() == _selectedFilter.toLowerCase();
              final matchSearch = t.keterangan.toLowerCase().contains(_searchQuery.toLowerCase());
              return matchLokasi && matchSearch;
            }).toList();

            return ListView(
              padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
              children: [
                // Tampilkan banner error jika ada masalah
                if (errorMessage != null)
                  _buildErrorBanner(errorMessage),

                BalanceCard(totalSaldo: data.saldo),
                const SizedBox(height: 24),
                
                // Arus Kas Sederhana
                Row(
                  children: [
                    _buildQuickStat(title: "Masuk", amount: data.totalSimpan, color: Colors.green, icon: Icons.arrow_downward),
                    const SizedBox(width: 12),
                    _buildQuickStat(title: "Keluar", amount: data.totalAmbil, color: Colors.red, icon: Icons.arrow_upward),
                  ],
                ),
                
                const SizedBox(height: 24),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    const Text("Penyimpanan", style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87)),
                    TextButton.icon(
                      onPressed: () => _showTransferForm(context, data.saldoLokasi),
                      icon: const Icon(Icons.compare_arrows, size: 18),
                      label: const Text("Transfer", style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold)),
                      style: TextButton.styleFrom(foregroundColor: const Color(0xFF4361EE)),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                GridView.count(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  crossAxisCount: 3,
                  crossAxisSpacing: 10,
                  mainAxisSpacing: 10,
                  childAspectRatio: 0.9,
                  children: [
                    LokasiCard(nama: "Dompet", saldo: data.saldoLokasi['dompet'] ?? 0, emoji: "👛", color1: const Color(0xFF4361EE), color2: const Color(0xFF3F37C9)),
                    LokasiCard(nama: "Celengan", saldo: data.saldoLokasi['celengan'] ?? 0, emoji: "🐷", color1: const Color(0xFFFF9E00), color2: const Color(0xFFFF8500)),
                    LokasiCard(nama: "GoPay", saldo: data.saldoLokasi['gopay'] ?? 0, emoji: "📱", color1: const Color(0xFF4CC9F0), color2: const Color(0xFF4895EF)),
                  ],
                ),
                
                const SizedBox(height: 32),
                
                // Header Riwayat + Filter
                Row(
                  children: [
                    const Text("Riwayat", style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87)),
                    const Spacer(),
                    IconButton(
                      onPressed: () {
                        if (data != null) {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => HistoryDetailPage(saldoLokasi: data.saldoLokasi),
                            ),
                          );
                        }
                      },
                      icon: const Icon(Icons.list_alt_rounded, color: Color(0xFF4361EE)),
                      tooltip: "Detail Riwayat",
                    ),
                  ],
                ),
                const SizedBox(height: 12),

                // Hanya tampilkan 5 transaksi terakhir di Home
                if (data.transaksi.isEmpty)
                  _buildEmptyState()
                else
                  ...data.transaksi.take(5).map((item) => _buildTransactionItem(item, formatter, data.saldoLokasi)),
                
                if (data.transaksi.length > 5)
                  Center(
                    child: TextButton(
                      onPressed: () {
                         Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => HistoryDetailPage(saldoLokasi: data.saldoLokasi),
                            ),
                          );
                      },
                      child: const Text("Lihat Semua Riwayat", style: TextStyle(fontWeight: FontWeight.bold)),
                    ),
                  ),
                  
                const SizedBox(height: 80), // Space for FAB
              ],
            );
          },
        ),
      ),
      floatingActionButton: FutureBuilder<TabunganResponse>(
        future: _api.getTabunganData(),
        builder: (context, snapshot) {
          return FloatingActionButton.extended(
            backgroundColor: const Color(0xFF4361EE),
            onPressed: () {
              if (snapshot.hasData) {
                _showFormTabungan(context, snapshot.data!.saldoLokasi);
              }
            },
            icon: const Icon(Icons.add, color: Colors.white),
            label: const Text("Transaksi", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
          );
        },
      ),
    ),
    );
  }

  Widget _buildErrorBanner(String message) {
    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      decoration: BoxDecoration(
        color: Colors.redAccent.withValues(alpha: 0.1),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.redAccent.withValues(alpha: 0.3)),
      ),
      child: Row(
        children: [
          const Icon(Icons.error_outline, color: Colors.redAccent, size: 20),
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              message,
              style: const TextStyle(color: Colors.redAccent, fontSize: 13, fontWeight: FontWeight.w500),
            ),
          ),
          IconButton(
            onPressed: () => setState(() {}),
            icon: const Icon(Icons.refresh, color: Colors.redAccent, size: 18),
            padding: EdgeInsets.zero,
            constraints: const BoxConstraints(),
          )
        ],
      ),
    );
  }

  Widget _buildQuickStat({required String title, required int amount, required Color color, required IconData icon}) {
    final formatter = NumberFormat.decimalPattern('id');
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(12),
        decoration: BoxDecoration(
          color: color.withValues(alpha: 0.1),
          borderRadius: BorderRadius.circular(16),
        ),
        child: Row(
          children: [
            Icon(icon, color: color, size: 20),
            const SizedBox(width: 8),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: TextStyle(fontSize: 11, color: color, fontWeight: FontWeight.w600)),
                Text("Rp ${formatter.format(amount)}", style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: Colors.black87)),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildTransactionItem(Tabungan item, NumberFormat formatter, Map<String, int> saldoLokasi) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.03), blurRadius: 10, offset: const Offset(0, 4))],
      ),
      child: ListTile(
        contentPadding: const EdgeInsets.only(left: 16, right: 8, top: 4, bottom: 4),
        leading: Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: item.type == 'simpan' ? Colors.green.withValues(alpha: 0.1) : Colors.red.withValues(alpha: 0.1),
            shape: BoxShape.circle,
          ),
          child: Icon(
            item.type == 'simpan' ? Icons.south_west_rounded : Icons.north_east_rounded,
            color: item.type == 'simpan' ? Colors.green : Colors.red,
            size: 20,
          ),
        ),
        title: Text(item.keterangan.isEmpty ? "Tanpa Keterangan" : item.keterangan, 
          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14)),
        subtitle: Text("${item.lokasi.toUpperCase()} • ${DateFormat('dd MMM').format(item.createdAt)}", 
          style: TextStyle(fontSize: 12, color: Colors.grey[600])),
        trailing: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text(
              "${item.type == 'simpan' ? '+' : '-'} Rp ${formatter.format(item.jumlah)}",
              style: TextStyle(
                fontWeight: FontWeight.w800,
                fontSize: 14,
                color: item.type == 'simpan' ? Colors.green[700] : Colors.red[700],
              ),
            ),
            PopupMenuButton<String>(
              icon: const Icon(Icons.more_vert, size: 20, color: Colors.grey),
              padding: EdgeInsets.zero,
              onSelected: (value) async {
                if (value == 'edit') {
                  _showFormTabungan(context, saldoLokasi, existingTabungan: item);
                } else if (value == 'delete') {
                  final confirm = await showDialog<bool>(
                    context: context,
                    builder: (context) => AlertDialog(
                      title: const Text("Hapus Transaksi?"),
                      content: const Text("Data yang dihapus tidak bisa dikembalikan."),
                      actions: [
                        TextButton(onPressed: () => Navigator.pop(context, false), child: const Text("Batal")),
                        TextButton(
                          onPressed: () => Navigator.pop(context, true), 
                          child: const Text("Hapus", style: TextStyle(color: Colors.red)),
                        ),
                      ],
                    ),
                  );
                  if (confirm == true) {
                    bool success = await _api.deleteTabungan(item.id);
                    if (success) setState(() {});
                  }
                }
              },
              itemBuilder: (context) => [
                const PopupMenuItem(value: 'edit', child: Row(children: [Icon(Icons.edit, size: 18), SizedBox(width: 8), Text("Edit")])),
                const PopupMenuItem(value: 'delete', child: Row(children: [Icon(Icons.delete, size: 18, color: Colors.red), SizedBox(width: 8), Text("Hapus", style: TextStyle(color: Colors.red))])),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildEmptyState() {
    return Column(
      children: [
        const SizedBox(height: 40),
        Icon(Icons.history_rounded, size: 64, color: Colors.grey[300]),
        const SizedBox(height: 16),
        Text("Belum ada transaksi", style: TextStyle(color: Colors.grey[500], fontWeight: FontWeight.w500)),
      ],
    );
  }
}

class CurrencyInputFormatter extends TextInputFormatter {
  @override
  TextEditingValue formatEditUpdate(TextEditingValue oldValue, TextEditingValue newValue) {
    if (newValue.text.isEmpty) return newValue;
    String cleanText = newValue.text.replaceAll(RegExp(r'[^0-9]'), '');
    if (cleanText.isEmpty) return const TextEditingValue();
    double value = double.parse(cleanText);
    final formatter = NumberFormat.decimalPattern('id');
    String newText = formatter.format(value);
    return newValue.copyWith(text: newText, selection: TextSelection.collapsed(offset: newText.length));
  }
}
