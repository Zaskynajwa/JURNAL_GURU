<?php
session_start();
include "koneksi.php";

// Ambil id jurnal dari URL
$id = $_GET['id'] ?? '';

if (!$id) {
    die("ID jurnal tidak ditemukan.");
}

// Ambil data jurnal
$id = mysqli_real_escape_string($koneksi, $id);
$query = mysqli_query($koneksi, "SELECT foto, kegiatan, tanggal FROM jurnal_mengajar WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data jurnal tidak ditemukan.");
}

$foto = $data['foto'];
$kegiatan = $data['kegiatan'];
$tanggal = $data['tanggal'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Foto Jurnal Mengajar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px;
}
.card {
    max-width: 600px;
    width: 100%;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background: #fff;
    text-align: center;
}
img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 15px;
}
h4 {
    margin-bottom: 10px;
}
</style>
</head>
<body>

<div class="card">
    <h4>📸 Foto Jurnal</h4>
    <p><b>Tanggal:</b> <?= htmlspecialchars($tanggal) ?></p>
    <p><b>Kegiatan:</b> <?= htmlspecialchars($kegiatan) ?></p>
    <?php if ($foto && file_exists($foto)): ?>
        <img src="<?= htmlspecialchars($foto) ?>" alt="Foto Jurnal">
    <?php else: ?>
        <p>Foto tidak tersedia.</p>
    <?php endif; ?>
</div>

</body>
</html>
