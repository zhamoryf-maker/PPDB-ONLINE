<?php
session_start();

/* =========================
   REDIRECT JIKA SUDAH LOGIN
========================= */
if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {

    if($_SESSION['level'] == "admin"){
        header("Location: dashboard_admin.php");
        exit;
    }else{
        header("Location: dashboard_siswa.php");
        exit;
    }
}

/* =========================
   ERROR MESSAGE HANDLING
========================= */
$error_message = "";
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - PPDB Premium</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

<style>
/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
}

/* ===== WRAPPER ===== */
.login-wrapper{
    display:flex;
    max-width:1000px;
    width:95%;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,0.1);
}

/* ===== LEFT ===== */
.brand-panel{
    flex:1;
    background:linear-gradient(135deg,#2563eb,#1e40af);
    color:white;
    padding:40px;
}

.brand-logo{
    font-weight:bold;
    font-size:20px;
    margin-bottom:40px;
}

.brand-panel h1{
    font-size:28px;
    margin-bottom:10px;
}

/* ===== RIGHT ===== */
.form-panel{
    flex:1;
    padding:50px;
}

.form-header h2{
    margin-bottom:5px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin-top:6px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid #ddd;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

button:hover{
    background:#1e40af;
}

/* ERROR */
.alert{
    background:#fee2e2;
    color:#991b1b;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .login-wrapper{
        flex-direction:column;
    }

    .brand-panel{
        text-align:center;
    }
}
</style>

</head>
<body>

<div class="login-wrapper">

    <!-- LEFT -->
    <div class="brand-panel">
        <div class="brand-logo">🎓 PPDB ONLINE</div>

        <h1>Selamat Datang</h1>
        <p>Login untuk masuk ke sistem PPDB</p>
    </div>

    <!-- RIGHT -->
    <div class="form-panel">

        <div class="form-header">
            <h2>Login Sistem</h2>
            <p>Masukkan akun Anda</p>
        </div>

        <?php if(!empty($error_message)): ?>
            <div class="alert">
                ⚠️ <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">

            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

        </form>

    </div>

</div>

</body>
</html>