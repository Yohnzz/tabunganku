<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pembelian | Tabungan Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --warning: #ff9e00;
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
            max-width: 1000px;
            margin: 0 auto;
            animation: fadeIn 0.6s ease-out;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
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
            font-size: 2.5rem;
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
            text-decoration: none;
            width: fit-content;
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
            margin-bottom: 20px;
        }

        .btn-success {
            background: linear-gradient(135deg, #4cc9f0, #3a86ff);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ff9e00, #ff5400);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f72585, #b5179e);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 14px;
        }

        .form-card {
            border-top: 6px solid var(--warning);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
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
            border-color: var(--warning);
            box-shadow: 0 0 0 3px rgba(255, 158, 0, 0.15);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.4s ease-out;
        }

        .alert-error {
            background-color: rgba(247, 37, 133, 0.1);
            border-left: 5px solid var(--danger);
            color: #b5179e;
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            border-left: 5px solid var(--success);
            color: #3a86ff;
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
            background: linear-gradient(135deg, var(--warning), #ff5400);
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
            background-color: #fff9f0;
        }

        td {
            padding: 16px 15px;
            color: var(--dark);
        }

        .priority-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .priority-1 {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--danger);
        }

        .priority-2 {
            background-color: rgba(255, 158, 0, 0.15);
            color: #ff9e00;
        }

        .priority-3 {
            background-color: rgba(67, 97, 238, 0.15);
            color: var(--primary);
        }

        .priority-4, .priority-5 {
            background-color: rgba(141, 153, 174, 0.15);
            color: var(--gray);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .status-bought {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }

        .status-not-bought {
            background-color: rgba(141, 153, 174, 0.15);
            color: var(--gray);
        }

        .action-form {
            display: inline;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #e9ecef;
        }

        .total-info {
            display: flex;
            gap: 30px;
        }

        .total-item {
            text-align: center;
        }

        .total-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 5px;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
        }

        .total-bought {
            color: var(--success);
        }

        .total-pending {
            color: var(--warning);
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
            border: 5px solid rgba(255, 158, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--warning);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 25px;
        }

        .loading-text {
            font-size: 1.2rem;
            color: var(--dark);
            font-weight: 600;
        }

        .priority-info {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .priority-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .priority-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin-top: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .total-section {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }
            
            .total-info {
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }
            
            .total-item {
                text-align: left;
                display: flex;
                justify-content: space-between;
                width: 100%;
            }
            
            .card {
                padding: 20px;
            }
            
            table {
                min-width: 600px;
            }

            .chart-container {
                height: 250px;
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
        <div class="loading-text">Memuat daftar pembelian...</div>
    </div>

    <div class="container">
        <header>
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h1>List Pembelian</h1>
            </div>
            <p class="subtitle">Kelola daftar belanja dengan prioritas yang jelas</p>
        </header>

        <!-- Tombol Kembali -->
        <a href="/" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <!-- Pesan Notifikasi -->
        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <!-- Form Tambah Barang -->
        <div class="card form-card">
            <h2><i class="fas fa-plus-circle"></i> Tambah Barang Baru</h2>
            <p style="margin-bottom: 20px; color: var(--gray);">Tambahkan barang yang ingin Anda beli ke dalam daftar</p>
            
            <form method="POST" action="{{ route('pembelian.store') }}" id="addItemForm">
                @csrf
                
                <div class="form-group">
                    <label for="nama_barang"><i class="fas fa-tag"></i> Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" placeholder="Contoh: Laptop, Baju, Buku" required>
                </div>
                
                <div class="form-group">
                    <label for="harga"><i class="fas fa-money-bill-wave"></i> Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" min="1" placeholder="Masukkan harga barang" required>
                </div>
                
                <div class="form-group">
                    <label for="prioritas"><i class="fas fa-flag"></i> Prioritas</label>
                    <input type="number" name="prioritas" id="prioritas" min="1" max="5" placeholder="1 (paling penting) - 5 (kurang penting)" required>
                    <div class="priority-info">
                        <div class="priority-item">
                            <div class="priority-dot" style="background-color: #f72585;"></div>
                            <span>1 = Sangat Penting</span>
                        </div>
                        <div class="priority-item">
                            <div class="priority-dot" style="background-color: #ff9e00;"></div>
                            <span>2 = Penting</span>
                        </div>
                        <div class="priority-item">
                            <div class="priority-dot" style="background-color: #4361ee;"></div>
                            <span>3 = Sedang</span>
                        </div>
                        <div class="priority-item">
                            <div class="priority-dot" style="background-color: #8d99ae;"></div>
                            <span>4-5 = Bisa ditunda</span>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-cart-plus"></i> Tambah ke Daftar
                </button>
            </form>
        </div>

        <!-- Ringkasan Pembelian -->
        <div class="card">
            <h2><i class="fas fa-chart-pie"></i> Ringkasan Daftar Belanja</h2>
            
            <div class="total-section">
                <div class="total-info">
                    <div class="total-item">
                        <div class="total-label">Total Barang</div>
                        <div class="total-value">{{ $items->count() }}</div>
                    </div>
                    <div class="total-item">
                        <div class="total-label">Total Harga</div>
                        <div class="total-value">Rp {{ number_format($items->sum('harga')) }}</div>
                    </div>
                    <div class="total-item">
                        <div class="total-label">Sudah Dibeli</div>
                        <div class="total-value total-bought">{{ $items->where('dibeli', true)->count() }}</div>
                    </div>
                    <div class="total-item">
                        <div class="total-label">Belum Dibeli</div>
                        <div class="total-value total-pending">{{ $items->where('dibeli', false)->count() }}</div>
                    </div>
                </div>
                
                <div>
                    @if($items->where('dibeli', false)->count() > 0)
                    <div class="total-label">Total Belanja Pending</div>
                    <div class="total-value total-pending">Rp {{ number_format($items->where('dibeli', false)->sum('harga')) }}</div>
                    @endif
                </div>
            </div>
        </div>

        
        <!-- Daftar Barang -->
        <div class="card">
            <h2><i class="fas fa-list"></i> Daftar Barang</h2>
            <p style="margin-bottom: 10px; color: var(--gray);">Kelola barang-barang yang ingin Anda beli</p>
            @if($prioritasWajib > 0)
            <div class="alert alert-error">
                <i class="fas fa-bell"></i>
                Masih ada <strong>{{ $prioritasWajib }}</strong> barang prioritas tinggi yang belum dibeli!
            </div>
            @endif
            
            <div class="table-container">
                @if(count($items) > 0)
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag"></i> Barang</th>
                            <th><i class="fas fa-money-bill-wave"></i> Harga</th>
                            <th><i class="fas fa-flag"></i> Prioritas</th>
                            <th><i class="fas fa-check-circle"></i> Status</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->nama_barang }}</strong>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($item->harga) }}</strong>
                            </td>
                            <td>
                                <span class="priority-badge priority-{{ $item->prioritas }}">
                                    Prioritas {{ $item->prioritas }}
                                </span>
                            </td>
                            <td>
                                @if($item->dibeli)
                                <span class="status-badge status-bought">
                                    <i class="fas fa-check"></i> Sudah dibeli
                                </span>
                                @else
                                <span class="status-badge status-not-bought">
                                    <i class="far fa-clock"></i> Belum dibeli
                                </span>
                                @endif
                            </td>
                            <td>
                                @if(!$item->dibeli)
                                <form method="POST" action="{{ route('pembelian.beli', $item->id) }}" class="action-form" id="buyForm{{ $item->id }}">
                                    @csrf
                                    @if($saldo < $item->harga)
                                    <button class="btn btn-danger btn-sm" disabled title="Saldo tidak cukup">
                                        <i class="fas fa-lock"></i> Saldo Kurang
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success btn-sm"
                                    onclick="confirmPurchase({{ $item->id }}, '{{ $item->nama_barang }}', {{ $item->harga }}, {{ $saldo }})">
                                    <i class="fas fa-shopping-cart"></i> Beli
                                </button>
                                @endif
                            </form>
                            @else
                            <span class="status-badge status-bought">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h3>Daftar pembelian kosong</h3>
                <p>Tambahkan barang yang ingin Anda beli menggunakan form di atas</p>
            </div>
            @endif
        </div>
    </div>
    <!-- Grafik Cashflow -->
    <div class="card">
        <h2><i class="fas fa-chart-bar"></i> Grafik Cashflow Bulanan</h2>
        <p style="margin-bottom: 10px; color: var(--gray);">Pantau pemasukan dan pengeluaran Anda sepanjang tahun</p>
        <div class="chart-container">
            <canvas id="cashflowChart"></canvas>
        </div>
    </div>
    
    <footer>
        <p>© {{ date('Y') }} Tabungan Digital. Prioritaskan kebutuhan belanja Anda dengan bijak.</p>
    </footer>
</div>

<!-- Modal Konfirmasi Pembelian -->
<div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: var(--radius); padding: 30px; max-width: 500px; width: 90%; box-shadow: var(--shadow);">
        <h2 style="color: var(--danger); margin-bottom: 15px;"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Pembelian</h2>
        <p style="margin-bottom: 20px; color: var(--dark);" id="modalMessage"></p>
        <div style="display: flex; gap: 15px; justify-content: flex-end;">
            <button id="cancelBtn" class="btn btn-back" style="background: var(--gray);">
                <i class="fas fa-times"></i> Batal
                </button>
                <button id="confirmBtn" class="btn btn-danger">
                    <i class="fas fa-check"></i> Ya, Beli Sekarang
                </button>
            </div>
        </div>
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

        // Inisialisasi Chart.js untuk Cashflow
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('cashflowChart');
            
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($cashflowLabels) !!},
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: {!! json_encode($cashflowPemasukan) !!},
                                backgroundColor: 'rgba(76, 201, 240, 0.7)',
                                borderColor: 'rgba(76, 201, 240, 1)',
                                borderWidth: 2,
                                borderRadius: 8
                            },
                            {
                                label: 'Pengeluaran',
                                data: {!! json_encode($cashflowPengeluaran) !!},
                                backgroundColor: 'rgba(247, 37, 133, 0.7)',
                                borderColor: 'rgba(247, 37, 133, 1)',
                                borderWidth: 2,
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    },
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        // Tampilkan loading screen saat form disubmit
        document.getElementById('addItemForm').addEventListener('submit', function(e) {
            // Validasi sederhana
            const namaBarang = document.getElementById('nama_barang').value;
            const harga = document.getElementById('harga').value;
            const prioritas = document.getElementById('prioritas').value;
            
            if (!namaBarang.trim()) {
                e.preventDefault();
                alert('Mohon masukkan nama barang');
                return;
            }
            
            if (!harga || harga <= 0) {
                e.preventDefault();
                alert('Mohon masukkan harga yang valid');
                return;
            }
            
            if (!prioritas || prioritas < 1 || prioritas > 5) {
                e.preventDefault();
                alert('Prioritas harus antara 1-5');
                return;
            }
            
            // Tampilkan loading screen
            document.getElementById('loadingScreen').style.display = 'flex';
            document.getElementById('loadingScreen').style.opacity = '1';
        });

        // Fungsi konfirmasi pembelian
        let currentFormId = null;
        
        function confirmPurchase(itemId, itemName, itemPrice, saldo) {
            const sisaSaldo = saldo - itemPrice;

            document.getElementById('modalMessage').innerHTML = `
                Anda akan membeli <strong>${itemName}</strong><br>
                Harga: <strong>Rp ${itemPrice.toLocaleString()}</strong><br><br>

                Saldo sekarang: <strong>Rp ${saldo.toLocaleString()}</strong><br>
                Saldo setelah beli:
                <strong style="color:${sisaSaldo < 0 ? 'red' : 'green'}">
                    Rp ${sisaSaldo.toLocaleString()}
                </strong><br><br>

                Lanjutkan pembelian?
            `;

            currentFormId = itemId;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        // Setup modal buttons
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('confirmModal').style.display = 'none';
            currentFormId = null;
        });

        document.getElementById('confirmBtn').addEventListener('click', function() {
            if (currentFormId) {
                // Tampilkan loading
                document.getElementById('loadingScreen').style.display = 'flex';
                document.getElementById('loadingScreen').style.opacity = '1';
                
                // Submit form
                document.getElementById('buyForm' + currentFormId).submit();
            }
        });

        // Tutup modal saat klik di luar
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                currentFormId = null;
            }
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

        // Tampilkan alert dari session jika ada
        @if(session('error'))
        setTimeout(() => {
            const errorAlert = document.querySelector('.alert-error');
            if (errorAlert) {
                errorAlert.style.animation = 'slideIn 0.4s ease-out';
            }
        }, 300);
        @endif

        // Fokus ke input pertama saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nama_barang').focus();
        });
    </script>
</body>
</html>