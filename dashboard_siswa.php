<?php
session_start();
include "koneksi.php";

// SECURITY CHECK
if(!isset($_SESSION['level']) || $_SESSION['level'] != "siswa"){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// AMBIL DATA SISWA (AMAN)
$query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY id DESC LIMIT 1");
$d = mysqli_fetch_assoc($query);

$nama_siswa = $d['nama'] ?? $username;
$status_siswa = $d['status'] ?? "Menunggu Verifikasi";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Siswa - PPDB</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background:#f1f5f9;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    height:100vh;
    background:#0f172a;
    color:white;
    position:fixed;
    padding:20px;
}

.brand{
    font-family:'Poppins',sans-serif;
    font-weight:700;
    margin-bottom:30px;
}

.menu{
    margin-top:20px;
}

.menu a{
    display:block;
    color:#94a3b8;
    text-decoration:none;
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
}

.menu a:hover{
    background:#1e293b;
    color:white;
}

/* MAIN */
.main{
    margin-left:250px;
    padding:30px;
    width:100%;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

/* PROFILE */
.profile{
    display:flex;
    align-items:center;
    gap:10px;
    background:white;
    padding:10px 15px;
    border-radius:30px;
}

.avatar{
    width:35px;
    height:35px;
    border-radius:50%;
    background:#22c55e;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-weight:bold;
}

/* STATUS */
.status{
    margin-top:20px;
    padding:15px;
    border-radius:12px;
    font-weight:bold;
}

.success{
    background:#dcfce7;
    color:#166534;
}

.pending{
    background:#fef9c3;
    color:#854d0e;
}

.reject{
    background:#fee2e2;
    color:#991b1b;
}

/* RESPONSIVE */
@media(max-width:768px){
    .sidebar{
        width:80px;
    }

    .main{
        margin-left:80px;
    }

    .brand, .menu span{
        display:none;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="brand">🎓 PPDB</div>

    <div class="menu">
        <a href="#">🏠 Dashboard</a>
    </div>

    <a href="logout.php" style="color:white; text-decoration:none; display:block; margin-top:30px;">
        🚪 Logout
    </a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="topbar">
        <h2>Dashboard Siswa</h2>

        <div class="profile">
            <div class="avatar">
                <?= strtoupper(substr($nama_siswa,0,1)); ?>
            </div>
            <div>
                <?= htmlspecialchars($nama_siswa); ?>
            </div>
        </div>
    </div>

    <!-- CARD -->
    <div class="card">
        <h3>Status Pendaftaran</h3>
        <p>Informasi status PPDB kamu</p>

        <?php
        $status = strtolower($status_siswa);

        if(in_array($status, ['diterima','lulus'])){
            echo '<div class="status success">🎉 Kamu DITERIMA</div>';
        }elseif(in_array($status, ['ditolak','gagal'])){
            echo '<div class="status reject">❌ Kamu DITOLAK</div>';
        }else{
            echo '<div class="status pending">⏳ Menunggu Verifikasi Admin</div>';
        }
        ?>

    </div>

</div>

</body>
</html>