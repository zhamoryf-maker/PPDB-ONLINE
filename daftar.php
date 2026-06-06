<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form PPDB Online - Premium Edition</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
/* RESET & BASE STYLES */
*{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', sans-serif;
    background: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(219, 234, 254) 100%);
    min-height: 100vh;
    color: #1e293b;
    display: flex;
    flex-direction: column;
}

/* NAVBAR GLASSMORPHISM */
.navbar {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    background: rgba(255, 255, 255, 0.7);
    border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    padding: 15px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
}

.navbar-brand {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 1.2rem;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-back {
    text-decoration: none;
    color: #475569;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(0, 0, 0, 0.05);
}

.btn-back:hover {
    background: #1e293b;
    color: #ffffff;
}

/* CONTAINER SETUP */
.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

/* CARD PREMIUM GRADIENT BORDER */
.card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 650px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.6);
}

/* TYPOGRAPHY */
.title {
    font-family: 'Poppins', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}

.subtitle {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 32px;
}

/* FORM ELEMENTS */
.form-group {
    margin-bottom: 22px;
}

label {
    display: block;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 14px 16px;
    font-family: inherit;
    font-size: 14px;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background-color: rgba(255, 255, 255, 0.9);
    color: #0f172a;
    outline: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

input::placeholder {
    color: #94a3b8;
}

input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    background-color: #ffffff;
}

/* GRID FORM SETUP */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media(max-width: 600px){
    .grid {
        grid-template-columns: 1fr;
        gap: 0;
    }
}

/* BUTTON MODERN ELEVATED */
button {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    transition: all 0.25s ease;
    margin-top: 10px;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
}

button:active {
    transform: translateY(0);
}

/* ALERT ANIMATION */
.alert {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 500;
    display: none;
    align-items: center;
    gap: 8px;
    animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-12px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>

<body>

<div class="navbar">
    <div class="navbar-brand">🎓 PPDB Online</div>
    <a href="index.php" class="btn-back">⬅ Kembali</a>
</div>

<div class="container">

    <div class="card">
        <div class="title">📋 Form Pendaftaran Siswa</div>
        <div class="subtitle">Silakan isi data dengan benar dan lengkap sesuai dokumen resmi</div>

        <div class="alert" id="alert">
            <span>✔</span> Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi selanjutnya.
        </div>

        <form action="simpan_daftar.php" method="POST">
            <div class="grid">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Contoh: Budi Santoso">
                </div>

                <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="asal" required placeholder="Contoh: Sdit arroyyan">
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <input type="text" name="alamat" required placeholder="Contoh: Jl. Merdeka No 10, Kota Jambi">
            </div>

            <button type="submit">Kirim Pendaftaran</button>
        </form>
    </div>

</div>

<script>
// Fungsi pemicu alert jika dibutuhkan nantinya
function showAlert(){
    const alertBox = document.getElementById("alert");
    alertBox.style.display = "flex";
}
</script>

</body>
</html>