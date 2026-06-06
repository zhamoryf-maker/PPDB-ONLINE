<?php
include "koneksi.php";

// ambil data dengan aman
$nama   = $_POST['nama'];
$asal   = $_POST['asal'];
$alamat = $_POST['alamat'];

// query INSERT yang sudah benar
$query = "INSERT INTO siswa (nama, alamat, asal_sekolah)
VALUES ('$nama', '$alamat', '$asal')";

if(mysqli_query($conn, $query)){
    echo "
    <script>
        alert('Pendaftaran berhasil!');
        window.location='index.php';
    </script>
    ";
}else{
    echo "Error: " . mysqli_error($conn);
}
?>