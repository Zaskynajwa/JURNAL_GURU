<?php
// --- KONEKSI DATABASE ---
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");
if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// --- DAFTAR KELAS & MAPEL ---
$kelas_list = [
  "X AKL 1","X AKL 2","X AKL 3",
  "X MPLB 1","X MPLB 2","X MPLB 3",
  "X PEMASARAN 1","X PEMASARAN 2","X PEMASARAN 3","X PPLG",
  "XI AKL 1","XI AKL 2","XI AKL 3",
  "XI MPLB 1","XI MPLB 2","XI MPLB 3",
  "XI PEMASARAN 1","XI PEMASARAN 2","XI PEMASARAN 3","XI PPLG",
  "XII AKL 1","XII AKL 2","XII AKL 3",
  "XII MPLB 1","XII MPLB 2","XII MPLB 3",
  "XII PEMASARAN 1","XII PEMASARAN 2","XII PEMASARAN 3","XII PPLG"
];

$mapel_list = ["Bahasa Indonesia","Bahasa Inggris","Matematika","PPLG","Produktif"];

// --- AMBIL FILTER ---
$kelas = $_GET['kelas'] ?? '';
$mapel = $_GET['mapel'] ?? '';
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$mode = $_GET['mode'] ?? '';

// --- QUERY DATA SISWA + PRESENSI ---
$data_presensi = [];

if ($kelas && $mapel) {
  if ($mode == 'harian') {
    $sql = "
      SELECT s.NIS, s.Nama, s.Kelas, '$mapel' AS mapel, COALESCE(p.status, '-') AS status
      FROM admin s
      LEFT JOIN input_presensi p
        ON s.NIS = p.NIS
       AND p.tanggal = '$tanggal'
       AND p.mapel = '$mapel'
      WHERE s.Kelas = '$kelas'
      ORDER BY s.Nama ASC
    ";
  } elseif ($mode == 'semua') {
    $sql = "
      SELECT s.NIS, s.Nama, s.Kelas, '$mapel' AS mapel, COALESCE(p.status, '-') AS status, p.tanggal
      FROM admin s
      LEFT JOIN input_presensi p
        ON s.NIS = p.NIS
       AND p.mapel = '$mapel'
      WHERE s.Kelas = '$kelas'
      ORDER BY p.tanggal DESC, s.Nama ASC
    ";
  }

  if (isset($sql)) {
    $result = mysqli_query($koneksi, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data_presensi[] = $row;
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekap Presensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 10px;
    }
    .card {
      border-radius: 15px;
    }
    .table th {
      background-color: #0d6efd;
      color: white;
    }
  </style>
</head>
<body>

<div class="container">

  <!-- CARD 1: FILTER -->
  <div class="card p-4 shadow-sm mb-4">
    <h4 class="text-primary fw-semibold mb-3">Rekap Presensi</h4>

    <form method="GET" class="row g-3">
  <!-- Kelas -->
  <div class="col-12">
    <label class="form-label fw-semibold">Kelas</label>
    <select name="kelas" class="form-select" required>
      <option value="">Pilih kelas</option>
      <?php foreach ($kelas_list as $k): ?>
        <option value="<?= $k ?>" <?= $kelas==$k?'selected':'' ?>><?= $k ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Mata Pelajaran -->
  <div class="col-12">
    <label class="form-label fw-semibold">Mata Pelajaran</label>
    <select name="mapel" class="form-select" required>
      <option value="">Pilih mapel</option>
      <?php foreach ($mapel_list as $m): ?>
        <option value="<?= $m ?>" <?= $mapel==$m?'selected':'' ?>><?= $m ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Tanggal -->
  <div class="col-12">
    <label class="form-label fw-semibold">Tanggal</label>
    <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>" required>
  </div>

  <!-- Tombol Rekap Harian -->
  <div class="col-12">
    <button type="submit" name="mode" value="harian" class="btn btn-primary w-100">Rekap Harian</button>
  </div>

  <!-- Tombol Rekap Semua Waktu -->
  <div class="col-12">
    <button type="submit" name="mode" value="semua" class="btn btn-success w-100">Rekap Semua Waktu</button>
  </div>
</form>

  </div>

  <!-- CARD 2: HASIL REKAP -->
  <?php if ($kelas && $mapel): ?>
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">
      <?= $mode == 'semua' ? 'Rekap Semua Waktu' : 'Rekap Harian - ' . $tanggal ?>
    </div>
    <div class="card-body">
      <p class="fw-semibold mb-3">
        Menampilkan presensi untuk mata pelajaran: <span class="text-primary"><?= htmlspecialchars($mapel) ?></span>
      </p>

      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIS</th>
              <th>Kelas</th>
              <th>Mata Pelajaran</th>
              <?php if ($mode == 'semua'): ?><th>Tanggal</th><?php endif; ?>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
  <?php if (count($data_presensi) > 0): ?>
    <?php $no=1; foreach($data_presensi as $d): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($d['Nama']) ?></td>
      <td><?= htmlspecialchars($d['NIS']) ?></td>
      <td><?= htmlspecialchars($d['Kelas']) ?></td>
      <td><?= htmlspecialchars($d['mapel']) ?></td>
      <?php if ($mode == 'semua'): ?><td><?= htmlspecialchars($d['tanggal'] ?? '-') ?></td><?php endif; ?>
      <td class="<?= $d['status'] == 'Hadir' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
        <?= htmlspecialchars($d['status']) ?>
      </td>
    </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="<?= $mode=='semua'?7:6 ?>">Belum ada data presensi.</td></tr>
  <?php endif; ?>
</tbody>

        </table>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
