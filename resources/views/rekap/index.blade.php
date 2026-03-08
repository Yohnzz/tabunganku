<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Keuangan Bulanan | Tabungan Digital</title>
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

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            color: var(--dark);
            background-color: white;
            transition: var(--transition);
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234361ee' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
        }

        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
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
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-back {
            background: var(--dark);
            margin-top: 20px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .summary-card {
            background: white;
            border-radius: var(--radius);
            padding: 25px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-8px);
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
        }

        .card-income::before {
            background: var(--success);
        }

        .card-expense::before {
            background: var(--danger);
        }

        .card-difference::before {
            background: var(--primary);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .income-icon {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }

        .expense-icon {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--danger);
        }

        .difference-icon {
            background-color: rgba(67, 97, 238, 0.15);
            color: var(--primary);
        }

        .card-content h3 {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .card-content p {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
        }

        .positive {
            color: var(--success);
        }

        .negative {
            color: var(--danger);
        }

        .table-container {
            overflow-x: auto;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-top: 30px;
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
            padding: 20px 15px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        tbody tr {
            border-bottom: 1px solid #f1f3f5;
            transition: var(--transition);
        }

        tbody tr:hover {
            background-color: #f8f9ff;
        }

        td {
            padding: 18px 15px;
            color: var(--dark);
        }

        .aksi-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .aksi-masuk {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }

        .aksi-keluar {
            background-color: rgba(247, 37, 133, 0.15);
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

        .month-title {
            text-align: center;
            margin: 30px 0;
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
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

        .date-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
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
            
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .filter-form {
                flex-direction: column;
            }
            
            .form-group {
                width: 100%;
            }
            
            .card {
                padding: 20px;
            }
        }

        footer {
            text-align: center;
            margin-top: 50px;
            color: var(--gray);
            font-size: 0.9rem;
            padding-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat data keuangan...</div>
    </div>

    <div class="container">
        <header>
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h1>Tabungan Digital</h1>
            </div>
            <p class="subtitle">Kelola keuangan Anda dengan mudah dan efisien</p>
        </header>

        <main>
            <div class="card">
                <h2><i class="fas fa-filter"></i> Filter Rekap Bulanan</h2>
                <p style="margin-top: 10px; color: var(--gray);">Pilih bulan dan tahun untuk melihat rekap keuangan</p>
                
                <form method="GET" action="{{ route('rekap') }}" class="filter-form" id="filterForm">
                    <div class="form-group">
                        <label for="bulan"><i class="far fa-calendar-alt"></i> Bulan</label>
                        <select name="bulan" id="bulan">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tahun"><i class="far fa-calendar"></i> Tahun</label>
                        <select name="tahun" id="tahun">
                            @for($y = 2020; $y <= date('Y') + 5; $y++)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-chart-pie"></i> Lihat Rekap
                    </button>
                </form>
            </div>

            <!-- Judul bulan dan tahun -->
            <div class="month-title">
                Rekap Keuangan
                <div class="date-badge">
                    {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
                </div>
            </div>

            <!-- Kartu ringkasan -->
            <div class="summary-cards">
                <div class="summary-card card-income">
                    <div class="card-icon income-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="card-content">
                        <h3>Total Pemasukan</h3>
                        <p class="positive">Rp {{ number_format($pemasukan) }}</p>
                    </div>
                </div>

                <div class="summary-card card-expense">
                    <div class="card-icon expense-icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="card-content">
                        <h3>Total Pengeluaran</h3>
                        <p class="negative">Rp {{ number_format($pengeluaran) }}</p>
                    </div>
                </div>

                <div class="summary-card card-difference pulse">
                    <div class="card-icon difference-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="card-content">
                        <h3>Saldo Akhir</h3>
                        <p class="{{ $selisih >= 0 ? 'positive' : 'negative' }}">Rp {{ number_format($selisih) }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabel transaksi -->
            <div class="card">
                <h2><i class="fas fa-history"></i> Riwayat Transaksi</h2>
                <p style="margin-top: 10px; color: var(--gray);">Detail pemasukan dan pengeluaran bulan ini</p>
                
                <div class="table-container">
                    @if(count($data) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th><i class="far fa-calendar"></i> Tanggal</th>
                                <th><i class="fas fa-exchange-alt"></i> Tipe</th>
                                <th><i class="fas fa-money-bill-wave"></i> Jumlah</th>
                                <th><i class="far fa-sticky-note"></i> Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <span class="aksi-badge {{ $d->aksi == 'masuk' ? 'aksi-masuk' : 'aksi-keluar' }}">
                                        {{ strtoupper($d->aksi) }}
                                    </span>
                                </td>
                                <td><strong>Rp {{ number_format($d->jumlah) }}</strong></td>
                                <td>{{ $d->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h3>Tidak ada transaksi pada periode ini</h3>
                        <p>Data transaksi akan muncul di sini setelah Anda menambahkan pemasukan atau pengeluaran</p>
                    </div>
                    @endif
                </div>
            </div>

            <div>
            <a href="/" style="text-decoration: none;">
                <button class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Tabungan
                </button>
            </a>
            <a href="/listpembelian" style="text-decoration: none;">
                <button class="btn btn-back">
                     Menuju Ke List Pembelian <i class="fas fa-arrow-right"></i>
                </button>
            </a>
            </div>
        </main>

        <footer>
            <p>© {{ date('Y') }} Tabungan Digital. Dibuat dengan <i class="fas fa-heart" style="color: #f72585;"></i> untuk mengelola keuangan Anda.</p>
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
        document.getElementById('filterForm').addEventListener('submit', function() {
            document.getElementById('loadingScreen').style.display = 'flex';
            document.getElementById('loadingScreen').style.opacity = '1';
        });

        // Animasi hover untuk kartu ringkasan
        document.querySelectorAll('.summary-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>