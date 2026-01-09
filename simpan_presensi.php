<?php
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");

if (isset($_POST['simpan'])) {
    $kelas = $_POST['kelas'];
    $mapel = $_POST['mapel'];
    $tanggal = $_POST['tanggal'];
    $status_list = $_POST['status'];

    foreach ($status_list as $nis => $status) {
        $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE nis='$nis'"));
        $nama = $siswa['nama'];
        $kelas = $siswa['kelas'];

        mysqli_query($koneksi, "INSERT INTO presensi (nis, nama, kelas, mapel, tanggal, status)
                                VALUES ('$nis', '$nama', '$kelas', '$mapel', '$tanggal', '$status')");
    }

    echo "<script>alert('Presensi berhasil disimpan!'); window.location='input_presensi.php';</script>";
}
?>
