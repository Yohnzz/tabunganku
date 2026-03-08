<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan Online | Kelola Keuangan Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --success: #4cc9f0;
            --danger: #f72585;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gray: #8d99ae;
            --shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            --radius: 16px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            background-color: #f0f2f5;
            color: var(--dark);
            min-height: 100vh;
            padding: 20px;
            background-image: radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(76, 201, 240, 0.05) 0%, transparent 20%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.6s ease-out;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            padding-top: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .logo-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: var(--shadow);
        }

        h1 {
            font-size: 2.8rem;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            margin-top: 5px;
        }

        .card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        h2, h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .balance-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .balance-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .balance-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .balance-card h2, 
        .balance-card h3,
        .balance-card p {
            position: relative;
            z-index: 2;
        }

        .balance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .balance-item {
            padding: 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .balance-item h4 {
            font-size: 0.9rem;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .balance-item p {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            color: var(--dark);
            background-color: white;
            transition: var(--transition);
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        /* Custom Toggle Switch untuk Jenis Transaksi */
        .toggle-container {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .toggle-option {
            flex: 1;
            position: relative;
        }

        .toggle-option input[type="radio"] {
            display: none;
        }

        .toggle-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 3px solid #e9ecef;
            border-radius: 16px;
            cursor: pointer;
            transition: var(--transition);
            background: white;
            text-align: center;
            gap: 10px;
        }

        .toggle-label:hover {
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .toggle-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: var(--transition);
            background: #f8f9fa;
        }

        .toggle-text {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark);
            transition: var(--transition);
        }

        .toggle-desc {
            font-size: 0.85rem;
            color: var(--gray);
            transition: var(--transition);
        }

        /* Style untuk Simpan */
        .toggle-option input[type="radio"]:checked + .toggle-label.simpan {
            border-color: var(--success);
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1), rgba(58, 134, 255, 0.05));
            box-shadow: 0 8px 25px rgba(76, 201, 240, 0.3);
        }

        .toggle-option input[type="radio"]:checked + .toggle-label.simpan .toggle-icon {
            background: linear-gradient(135deg, #4cc9f0, #3a86ff);
            color: white;
            animation: bounceIn 0.5s ease;
        }

        .toggle-option input[type="radio"]:checked + .toggle-label.simpan .toggle-text {
            color: #3a86ff;
        }

        /* Style untuk Ambil */
        .toggle-option input[type="radio"]:checked + .toggle-label.ambil {
            border-color: var(--danger);
            background: linear-gradient(135deg, rgba(247, 37, 133, 0.1), rgba(181, 23, 158, 0.05));
            box-shadow: 0 8px 25px rgba(247, 37, 133, 0.3);
        }

        .toggle-option input[type="radio"]:checked + .toggle-label.ambil .toggle-icon {
            background: linear-gradient(135deg, #f72585, #b5179e);
            color: white;
            animation: bounceIn 0.5s ease;
        }

        .toggle-option input[type="radio"]:checked + .toggle-label.ambil .toggle-text {
            color: #f72585;
        }

        .btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
            width: 100%;
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-success {
            background: linear-gradient(135deg, #4cc9f0, #3a86ff);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f72585, #b5179e);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--dark), #4a4e69);
        }

        .table-container {
            overflow-x: auto;
            border-radius: var(--radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 700px;
        }

        thead {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        th {
            padding: 18px 15px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
        }

        tbody tr {
            border-bottom: 1px solid #f1f3f5;
            transition: var(--transition);
        }

        tbody tr:hover {
            background-color: #f8f9ff;
        }

        td {
            padding: 16px 15px;
            color: var(--dark);
        }

        .type-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .type-simpan {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }

        .type-ambil {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--danger);
        }

        .saldo-change {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .saldo-positive {
            color: var(--success);
        }

        .saldo-negative {
            color: var(--danger);
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 5px solid rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 25px;
        }

        .loading-text {
            font-size: 1.2rem;
            color: var(--dark);
            font-weight: 600;
        }

        .transaction-form-card {
            background: white;
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            border-top: 6px solid var(--primary);
            transition: var(--transition);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .form-actions .btn {
            flex: 1;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #e9ecef;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .balance-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .card {
                padding: 20px;
            }
            
            table {
                min-width: 600px;
            }

            .toggle-container {
                flex-direction: column;
            }

            .toggle-label {
                padding: 15px;
            }

            .toggle-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }
        }

        footer {
            text-align: center;
            margin-top: 50px;
            color: var(--gray);
            font-size: 0.9rem;
            padding-bottom: 30px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .nav-buttons .btn {
            width: auto;
            flex: 1;
            min-width: 200px;
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat data tabungan...</div>
    </div>

    <div class="container">
        <header>
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <h1>Tabungan Online</h1>
            </div>
            <p class="subtitle">Kelola keuangan pribadi dengan mudah dan aman</p>
        </header>

        <!-- Navigasi -->
        <div class="nav-buttons">
            <a href="/rekap" class="btn btn-secondary">
                <i class="fas fa-chart-pie"></i> Lihat Rekap Bulanan
            </a>
            <a href="/listpembelian" class="btn btn-secondary">
                <i class="fas fa-shopping-cart"></i> List Pembelian
            </a>
        </div>

        <!-- Kartu Saldo -->
        <div class="card balance-card">
            <h2><i class="fas fa-wallet"></i> Ringkasan Keuangan</h2>
            <div class="balance-grid">
                <div class="balance-item">
                    <h4>Total Simpan</h4>
                    <p>Rp {{ number_format($totalSimpan) }}</p>
                </div>
                <div class="balance-item">
                    <h4>Total Ambil</h4>
                    <p>Rp {{ number_format($totalAmbil) }}</p>
                </div>
                <div class="balance-item pulse">
                    <h4>Saldo Saat Ini</h4>
                    <p class="saldo-change {{ $saldo >= 0 ? 'saldo-positive' : 'saldo-negative' }}">
                        Rp {{ number_format($saldo) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Transaksi -->
        <div class="transaction-form-card" id="formCard">
            <h3><i class="fas fa-plus-circle"></i> Tambah Transaksi Baru</h3>
            
            <form method="POST" action="{{ route('tabungan.store') }}" id="transactionForm">
                @csrf
                
                <!-- Custom Toggle untuk Jenis Transaksi -->
                <div class="form-group">
                    <label><i class="fas fa-exchange-alt"></i> Pilih Jenis Transaksi</label>
                    
                    <div class="toggle-container">
                        <div class="toggle-option">
                            <input type="radio" name="type" id="type-simpan" value="simpan" checked>
                            <label for="type-simpan" class="toggle-label simpan">
                                <div class="toggle-icon">
                                    <i class="fas fa-piggy-bank"></i>
                                </div>
                                <div class="toggle-text">Simpan</div>
                                <div class="toggle-desc">Menabung uang</div>
                            </label>
                        </div>
                        
                        <div class="toggle-option">
                            <input type="radio" name="type" id="type-ambil" value="ambil">
                            <label for="type-ambil" class="toggle-label ambil">
                                <div class="toggle-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="toggle-text">Ambil</div>
                                <div class="toggle-desc">Penarikan uang</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="jumlah"><i class="fas fa-money-bill-wave"></i> Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" min="1" required placeholder="Masukkan jumlah">
                </div>
                
                <div class="form-group">
                    <label for="keterangan"><i class="fas fa-sticky-note"></i> Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" placeholder="Contoh: Gaji bulanan, belanja kebutuhan" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-arrow-down"></i> Simpan Uang
                    </button>
                    <button type="button" class="btn" onclick="resetForm()">
                        <i class="fas fa-redo"></i> Reset Form
                    </button>
                </div>
            </form>
        </div>

        <!-- Riwayat Transaksi Terbaru -->
        <div class="card">
            <h3><i class="fas fa-history"></i> Riwayat Transaksi Terbaru</h3>
            <p style="margin-bottom: 10px; color: var(--gray);">5 transaksi terakhir Anda</p>
            
            <div class="table-container">
                @if(count($data) > 0)
                <table>
                    <thead>
                        <tr>
                            <th><i class="far fa-calendar"></i> Tanggal</th>
                            <th><i class="fas fa-exchange-alt"></i> Jenis</th>
                            <th><i class="fas fa-money-bill-wave"></i> Jumlah</th>
                            <th><i class="far fa-sticky-note"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentTransactions = $data->take(5);
                        @endphp
                        @foreach($recentTransactions as $row)
                        <tr>
                            <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="type-badge {{ $row->type == 'simpan' ? 'type-simpan' : 'type-ambil' }}">
                                    {{ ucfirst($row->type) }}
                                </span>
                            </td>
                            <td><strong>Rp {{ number_format($row->jumlah) }}</strong></td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3>Belum ada transaksi</h3>
                    <p>Mulai tambah transaksi pertama Anda menggunakan form di atas</p>
                </div>
                @endif
            </div>
        </div>

        <!-- History Keuangan Lengkap -->
        <div class="card">
            <h3><i class="fas fa-chart-line"></i> History Keuangan Lengkap</h3>
            <p style="margin-bottom: 10px; color: var(--gray);">Catatan lengkap semua perubahan saldo</p>
            
            <div class="table-container">
                @if(count($histories) > 0)
                <table>
                    <thead>
                        <tr>
                            <th><i class="far fa-calendar"></i> Tanggal</th>
                            <th><i class="fas fa-exchange-alt"></i> Aksi</th>
                            <th><i class="fas fa-money-bill-wave"></i> Jumlah</th>
                            <th><i class="fas fa-wallet"></i> Saldo Sebelum</th>
                            <th><i class="fas fa-wallet"></i> Saldo Sesudah</th>
                            <th><i class="far fa-sticky-note"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $h)
                        <tr>
                            <td>{{ $h->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="type-badge {{ $h->aksi == 'simpan' ? 'type-simpan' : 'type-ambil' }}">
                                    {{ strtoupper($h->aksi) }}
                                </span>
                            </td>
                            <td><strong>Rp {{ number_format($h->jumlah) }}</strong></td>
                            <td>Rp {{ number_format($h->saldo_sebelum) }}</td>
                            <td>
                                <span class="saldo-change {{ $h->saldo_sesudah >= $h->saldo_sebelum ? 'saldo-positive' : 'saldo-negative' }}">
                                    Rp {{ number_format($h->saldo_sesudah) }}
                                </span>
                            </td>
                            <td>{{ $h->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Belum ada history keuangan</h3>
                    <p>History akan muncul setelah Anda melakukan transaksi</p>
                </div>
                @endif
            </div>
        </div>

        <footer>
            <p>© {{ date('Y') }} Tabungan Online. Kelola keuangan dengan lebih baik.</p>
        </footer>
    </div>

    <script>
        // Sembunyikan loading screen setelah halaman dimuat
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loadingScreen');
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                loadingScreen.style.display = 'none';
            }, 500);
        });

        // Tampilkan loading screen saat form disubmit
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            // Validasi sederhana
            const jumlah = document.getElementById('jumlah').value;
            const keterangan = document.getElementById('keterangan').value;
            
            if (!jumlah || jumlah <= 0) {
                e.preventDefault();
                alert('Mohon masukkan jumlah yang valid');
                return;
            }
            
            if (!keterangan.trim()) {
                e.preventDefault();
                alert('Mohon isi keterangan transaksi');
                return;
            }
            
            // Tampilkan loading screen
            document.getElementById('loadingScreen').style.display = 'flex';
            document.getElementById('loadingScreen').style.opacity = '1';
            
            // Ubah teks tombol submit
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Fungsi reset form
        function resetForm() {
            document.getElementById('transactionForm').reset();
            document.getElementById('type-simpan').checked = true;
            updateFormStyle();
        }

        // Update style form berdasarkan pilihan
        function updateFormStyle() {
            const formCard = document.getElementById('formCard');
            const submitBtn = document.getElementById('submitBtn');
            const simpanChecked = document.getElementById('type-simpan').checked;
            
            if (simpanChecked) {
                formCard.style.borderTopColor = 'var(--success)';
                submitBtn.className = 'btn btn-success';
                submitBtn.innerHTML = '<i class="fas fa-arrow-down"></i> Simpan Uang';
            } else {
                formCard.style.borderTopColor = 'var(--danger)';
                submitBtn.className = 'btn btn-danger';
                submitBtn.innerHTML = '<i class="fas fa-arrow-up"></i> Ambil Uang';
            }
        }

        // Event listener untuk radio buttons
        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', updateFormStyle);
        });

        // Animasi hover untuk kartu
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Inisialisasi style form
        document.addEventListener('DOMContentLoaded', function() {
            updateFormStyle();
        });
    </script>
</body>
</html>