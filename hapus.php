<?php
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    $query = "DELETE FROM admin WHERE nis='$nis'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='manajemen_siswa.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "NIS tidak ditemukan.";
}

mysqli_close($koneksi);
?>
