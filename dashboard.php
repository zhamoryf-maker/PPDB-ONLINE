<?php
session_start();

// 1. KEAMANAN: Pastikan hanya user dengan level admin yang bisa mengakses
if(!isset($_SESSION['level']) || $_SESSION['level'] != "admin"){
    header("Location: login.php");
    exit;
}

// 2. KONEKSI: Hubungkan dengan file koneksi database Anda
include "koneksi.php";

// 3. AMBIL DATA: Mengambil data pendaftar dari tabel siswa
$data = mysqli_query($conn, "SELECT * FROM siswa");

// 4. STATISTIK: Menghitung jumlah data untuk ringkasan di dashboard
$total_siswa = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PPDB Premium</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* RESET STYLES */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Abu-abu netral sangat terang */
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR NAVIGATION */
        .sidebar {
            width: 260px;
            background-color: #0f172a; /* Gelap Slate */
            color: #ffffff;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            height: 100vh;
            z-index: 10;
        }

        .sidebar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
            margin-bottom: 8px;
        }

        .menu-item.active, .menu-item:hover {
            background-color: #1e293b;
            color: #3b82f6; /* Warna aksen biru */
        }

        .btn-logout {
            background-color: #ef4444;
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background-color: #dc2626;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
        }

        /* TOPBAR / PROFILE HEADER */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .topbar h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
            color: #0f172a;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .avatar {
            width: 32px;
            height: 32px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* NOTIFIKASI ALERT */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .stat-card p {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* TABLE CARD PREMIUM */
        .table-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .table-header {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            color: #0f172a;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.95rem;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            padding: 16px 24px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        /* DYNAMIC STATUS BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-berhasil, .badge-lulus, .badge-diterima { background-color: #dcfce7; color: #166534; }
        .badge-proses, .badge-pending { background-color: #fef9c3; color: #854d0e; }
        .badge-gagal, .badge-ditolak { background-color: #fef2f2; color: #991b1b; }
        .badge-default { background-color: #f1f5f9; color: #475569; }

        /* ACTION BUTTONS */
        .action-container {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-accept {
            background-color: #2563eb;
            color: white;
        }

        .btn-accept:hover {
            background-color: #1d4ed8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-reject {
            background-color: #ffffff;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }

        .btn-reject:hover {
            background-color: #f8fafc;
            color: #ef4444;
            border-color: #fca5a5;
        }

        /* RESPONSIVE DESIGN (MOBILE ADAPTIVE) */
        @media (max-width: 1024px) {
            .sidebar { width: 80px; padding: 20px 10px; align-items: center; }
            .sidebar-brand span, .menu-item span { display: none; }
            .main-content { margin-left: 80px; padding: 24px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div>
            <div class="sidebar-brand">
                <span>🎓 PPDB Admin</span>
            </div>
            <nav>
                <a href="dashboard.php" class="menu-item active">
                    📁 <span>Data Siswa</span>
                </a>
            </nav>
        </div>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="main-content">
        
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="admin-profile">
                <div class="avatar">A</div>
                <span>Administrator</span>
            </div>
        </div>

        <?php if (isset($_SESSION['notif'])): ?>
            <div class="alert alert-success">
                <span>✓</span> <?php echo $_SESSION['notif']; unset($_SESSION['notif']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['notif_error'])): ?>
            <div class="alert alert-danger">
                <span>⚠️</span> <?php echo $_SESSION['notif_error']; unset($_SESSION['notif_error']); ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <p>Total Pendaftar</p>
                <h3><?= $total_siswa; ?></h3>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h2>📋 Daftar Berkas Masuk</h2>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Asal Sekolah</th>
                            <th>Alamat Rumah</th>
                            <th>Status Kelulusan</th>
                            <th style="text-align: center;">Aksi Kredensial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($total_siswa > 0) {
                            while($d = mysqli_fetch_array($data)){ 
                                // Deteksi otomatis isi kolom status untuk menentukan kelas warna badge
                                $status_clean = strtolower(trim($d['status']));
                                $badge_class = "badge-default";
                                
                                if(in_array($status_clean, ['lulus', 'berhasil', 'diterima'])) {
                                    $badge_class = "badge-berhasil";
                                } elseif(in_array($status_clean, ['proses', 'pending', 'diverifikasi'])) {
                                    $badge_class = "badge-proses";
                                } elseif(in_array($status_clean, ['gagal', 'ditolak'])) {
                                    $badge_class = "badge-gagal";
                                }
                        ?>
                        <tr>
                            <td style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($d['nama']); ?></td>
                            <td><?= htmlspecialchars($d['asal_sekolah']); ?></td>
                            <td><?= htmlspecialchars($d['alamat']); ?></td>
                            <td>
                                <span class="badge <?= $badge_class; ?>">
                                    <?= htmlspecialchars($d['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-container" style="justify-content: center;">
                                    <a href="update_status.php?id=<?= $d['id']; ?>&status=Diterima" 
                                       class="btn-action btn-accept" 
                                       onclick="return confirm('Apakah Anda yakin ingin MENERIMA siswa ini?')">
                                       ✓ Terima
                                    </a>
                                    
                                    <a href="update_status.php?id=<?= $d['id']; ?>&status=Ditolak" 
                                       class="btn-action btn-reject" 
                                       onclick="return confirm('Apakah Anda yakin ingin MENOLAK siswa ini?')">
                                       ✕ Tolak
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #64748b; padding: 40px;">Belum ada data pendaftar baru yang masuk.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>