# 💰 TabunganKu - Aplikasi Pencatatan Keuangan Pribadi

**TabunganKu** adalah aplikasi Flutter modern yang dirancang untuk membantu pengguna mengelola tabungan mereka di berbagai tempat penyimpanan (Dompet, Celengan, GoPay) secara terorganisir dan aman.

## 🚀 Fitur Utama
- **Sistem Autentikasi**: Login dan Register menggunakan **Supabase Auth**.
- **Data Per-User (Secure)**: Menggunakan *Row Level Security* (RLS) agar data antar pengguna tidak bercampur.
- **Multi-Lokasi Saldo**: Pisahkan catatan uang Anda di Dompet, Celengan, atau saldo Digital (GoPay).
- **Transfer Antar Saldo**: Fitur untuk memindahkan saldo dari satu lokasi ke lokasi lain.
- **Template Cepat**: Simpan nominal transaksi yang sering digunakan untuk input lebih cepat.
- **Riwayat Lengkap**: Cari dan filter riwayat transaksi berdasarkan lokasi atau keterangan.
- **Modern UI**: Menggunakan Material 3 dengan skema warna yang bersih dan interaktif.
- **Home Widget**: Pantau saldo langsung dari layar utama HP Anda (Android).

## 🛠️ Teknologi yang Digunakan
- **Framework**: [Flutter](https://flutter.dev)
- **Backend**: [Supabase](https://supabase.com/) (Auth & Database)
- **State Management**: [Provider](https://pub.dev/packages/provider)
- **Local Integration**: [Home Widget](https://pub.dev/packages/home_widget) untuk integrasi widget Android.
- **Format Data**: `intl` untuk format mata uang Rupiah.

## 📁 Struktur Folder
```text
lib/
├── core/               # Konfigurasi (Supabase, Constants)
├── models/             # Model data (Tabungan, Template)
├── pages/              # Halaman fitur baru (Auth, Splash)
├── providers/          # Pengelola status (Auth Provider)
├── services/           # Logika API & Service Supabase
├── views/              # Halaman utama & Widget UI
│   ├── pages/          # Home, History
│   └── widgets/        # Komponen UI (BalanceCard, LokasiCard)
└── main.dart           # Entry point aplikasi
```

## 📈 Versi Saat Ini
**V 1.0.2.0**
