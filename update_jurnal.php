<?php
$koneksi = mysqli_connect("localhost","root","","jurnal");
if (!$koneksi) die("Koneksi gagal: ".mysqli_connect_error());

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $kelas = mysqli_real_escape_string($koneksi,$_POST['kelas']);
    $mapel = mysqli_real_escape_string($koneksi,$_POST['mapel']);
    $tanggal = $_POST['tanggal'];
    $jam_awal = $_POST['jam_awal'];
    $jam_akhir = $_POST['jam_akhir'];
    $hadir = intval($_POST['hadir']);
    $tidak_hadir = $_POST['tidak_hadir'];
    $nama_tidak_hadir = mysqli_real_escape_string($koneksi,$_POST['nama_tidak_hadir']);
    $kegiatan = mysqli_real_escape_string($koneksi,$_POST['kegiatan']);
    $materi = mysqli_real_escape_string($koneksi,$_POST['materi']);
    $keterangan = mysqli_real_escape_string($koneksi,$_POST['keterangan']);

    $sql = "UPDATE jurnal_mengajar SET 
        kelas='$kelas',
        mapel='$mapel',
        tanggal='$tanggal',
        jam_awal='$jam_awal',
        jam_akhir='$jam_akhir',
        hadir='$hadir',
        tidak_hadir='$tidak_hadir',
        nama_tidak_hadir='$nama_tidak_hadir',
        kegiatan='$kegiatan',
        materi='$materi',
        keterangan='$keterangan'
        WHERE id=$id";

    if(mysqli_query($koneksi,$sql)){
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error", "msg"=>mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(["status"=>"error","msg"=>"ID tidak ditemukan"]);
}
?>
