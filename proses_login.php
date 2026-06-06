<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if($data){

    $_SESSION['login_status'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];

    if($data['level'] == "admin"){
        header("Location: dashboard_admin.php");
    }else{
        header("Location: dashboard_siswa.php");
    }

}else{
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
}
?>