<?php
session_start();

// 1. KEAMANAN: Pastikan hanya user dengan level admin yang bisa mengakses
if (!isset($_SESSION['level']) || $_SESSION['level'] != "admin") {
    header("Location: login.php");
    exit;
}

// 2. KONEKSI: Panggil file koneksi database
include "koneksi.php";

$status_proses = "Memproses...";
$sukses = false;

// 3. PROSES DATA
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id     = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    if (in_array($status, ['Diterima', 'Ditolak'])) {
        $query = "UPDATE siswa SET status = '$status' WHERE id = '$id'";
        $exec  = mysqli_query($conn, $query);

        if ($exec) {
            $sukses = true;
            $status_proses = "Status Berhasil Diperbarui!";
            $_SESSION['notif'] = "Status siswa berhasil diperbarui menjadi $status!";
        } else {
            $status_proses = "Gagal Memperbarui Data.";
            $_SESSION['notif_error'] = "Gagal memperbarui status siswa.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Status... - PPDB Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Warna background dashboard */
            color: #1e293b;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* CARD PROGRESS MATCHING DASHBOARD STYLE */
        .process-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .icon-status {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* ANIMASI LOADING SPINNER (Tema Biru Dashboard) */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f1f5f9;
            border-top: 5px solid #2563eb; /* Warna utama dashboard */
            border-radius: 50%;
            margin: 0 auto 24px auto;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: 8px;
        }

        p {
            font-size: 0.9rem;
            color: #64748b;
        }
    </style>

    <script>
        setTimeout(function(){
            window.location.href = "dashboard_admin.php";
        }, 1500);
    </script>
</head>
<body>

    <div class="process-card">
        <?php if($sukses): ?>
            <div class="icon-status">🎉</div>
            <h2><?= $status_proses; ?></h2>
            <p>Mengalihkan kembali ke dashboard...</p>
        <?php else: ?>
            <div class="spinner"></div>
            <h2><?= $status_proses; ?></h2>
            <p>Sistem sedang menyimpan perubahan data secara aman.</p>
        <?php endif; ?>
    </div>

</body>
</html>