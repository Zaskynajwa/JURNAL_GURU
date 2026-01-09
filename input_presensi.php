<?php
session_start();

// === KONEKSI DATABASE ===
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// === DAFTAR KELAS & MAPEL ===
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

// === FILTER ===
$kelas = $_GET['kelas'] ?? '';
$mapel = $_GET['mapel'] ?? '';
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

// === AMBIL DATA SISWA ===
$data_siswa = [];
if ($kelas != '') {
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE kelas='$kelas' ORDER BY nama ASC");
    while ($r = mysqli_fetch_assoc($query)) {
        $data_siswa[] = $r;
    }
}

// === SIMPAN PRESENSI ===
if (isset($_POST['status'])) {
    $hadir = 0;
    $tidak_hadir = 0;
    $daftar_tidak_hadir = [];

    foreach ($_POST['status'] as $nis => $status) {
        if ($status == 'Hadir') {
            $hadir++;
        } else {
            $tidak_hadir++;
            $q = mysqli_query($koneksi, "SELECT nama FROM admin WHERE nis='$nis'");
            $d = mysqli_fetch_assoc($q);
            if ($d) {
                $daftar_tidak_hadir[] = $d['nama'] . " ($status)";
            }
        }

        mysqli_query($koneksi, "
            INSERT INTO input_presensi (NIS, mapel, tanggal, status)
            VALUES ('$nis', '{$_POST['mapel']}', '$tanggal', '$status')
            ON DUPLICATE KEY UPDATE status='$status'
        ");
    }

    // Simpan data ringkasan ke session untuk jurnal
    $_SESSION['hadir'] = $hadir;
    $_SESSION['tidak_hadir'] = $tidak_hadir;
    $_SESSION['nama_tidak_hadir'] = implode(", ", $daftar_tidak_hadir);
    $_SESSION['mapel_terakhir'] = $_POST['mapel'];

    header("Location: ".$_SERVER['PHP_SELF']."?kelas=$kelas&mapel=".$_POST['mapel']."&tanggal=$tanggal");
    exit;
}

// === VAR UNTUK JURNAL ===
$jumlah_hadir = $_SESSION['hadir'] ?? 0;
$jumlah_tidak_hadir = $_SESSION['tidak_hadir'] ?? 0;
$daftar_tidak_hadir = $_SESSION['nama_tidak_hadir'] ?? '';
$mapel_terakhir = $_SESSION['mapel_terakhir'] ?? '';

// === SIMPAN JURNAL MENGAJAR ===
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kegiatan'])) {
    $mapel_jurnal = mysqli_real_escape_string($koneksi, $_POST['mapel_jurnal']);
    $kelas_jurnal = isset($_POST['kelas_jurnal']) ? mysqli_real_escape_string($koneksi, $_POST['kelas_jurnal']) : '';
    $jam_awal = mysqli_real_escape_string($koneksi, $_POST['jam_awal']);
    $jam_akhir = mysqli_real_escape_string($koneksi, $_POST['jam_akhir']);
    $hadir = (int)$_POST['hadir'];
    $tidak_hadir = (int)$_POST['tidak_hadir'];
    $nama_tidak_hadir = mysqli_real_escape_string($koneksi, $_POST['nama_tidak_hadir']);
    $kegiatan = mysqli_real_escape_string($koneksi, $_POST['kegiatan']);
    $materi = mysqli_real_escape_string($koneksi, $_POST['materi']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $tanggal_jurnal = $tanggal;

    $sql = "INSERT INTO jurnal_mengajar 
        (mapel, kelas, jam_awal, jam_akhir, hadir, tidak_hadir, nama_tidak_hadir, kegiatan, materi, keterangan, tanggal)
        VALUES 
        ('$mapel_jurnal', '$kelas_jurnal', '$jam_awal', '$jam_akhir', $hadir, $tidak_hadir, '$nama_tidak_hadir', '$kegiatan', '$materi', '$keterangan', '$tanggal_jurnal')";

    if (mysqli_query($koneksi, $sql)) {
        $pesan_jurnal = "Jurnal mengajar berhasil disimpan.";
    } else {
        $pesan_jurnal = "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Presensi & Jurnal Mengajar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding-top: 80px;
}
header {
    background-color: #2c3e50;
    color: white;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 10;
}
header h1 { font-size: 20px; margin: 0; }
header p { margin: 0; font-size: 14px; opacity: 0.8; }
.logout-btn {
    background-color: #e74c3c;
    border: none;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}
.logout-btn:hover { background-color: #c0392b; }
.container-custom {
    max-width: 1100px;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    margin: 0 auto 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.table th { background-color: #0d6efd; color: white; }
.btn-purple {
    background-color: #6f42c1;
    color: white;
}
.btn-purple:hover { background-color: #59359a; }
.back-btn {
    background-color: #3498db;
    border: none;
    color: white;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}
.back-btn:hover { background-color: #2980b9; }
</style>
</head>
<body>
<header>
    <div>
        <h1>📋 Jurnal Mengajar & Presensi</h1>
        <p>Selamat datang, <b><?= $_SESSION['username'] ?? 'Guru'; ?></b></p>
    </div>
    <form action="logout.php" method="post">
        <button class="logout-btn">Keluar</button>
    </form>
</header>

<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">📝 Input Presensi</h4>
        <button class="back-btn" onclick="location.href='dashboard.php'">Kembali ke Dashboard</button>
    </div>

    <!-- Filter Presensi -->
    <div class="card p-4 shadow-sm mb-4">
        <form method="GET" class="row g-3 align-items-end mb-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kelas</label>
                <select name="kelas" class="form-select" required>
                    <option value="">Pilih kelas</option>
                    <?php foreach ($kelas_list as $k): ?>
                        <option value="<?= $k ?>" <?= $kelas==$k?'selected':'' ?>><?= $k ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Mata Pelajaran</label>
                <select name="mapel" class="form-select" required>
                    <option value="">Pilih mapel</option>
                    <?php foreach ($mapel_list as $m): ?>
                        <option value="<?= $m ?>" <?= $mapel==$m?'selected':'' ?>><?= $m ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control" required>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Tampilkan</button>
                <div class="text-end">
    <button type="button" id="btnSimpanHadir" class="btn btn-success mt-2">
        Simpan Presensi (Hadir Semua)
    </button>
</div>
                <button type="button" class="btn btn-purple flex-fill">Lihat</button>
            </div>
        </form>

        <!-- Tabel Presensi -->
        <?php if ($kelas && $mapel): ?>
        <form method="POST">
            <input type="hidden" name="mapel" value="<?= htmlspecialchars($mapel) ?>">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data_siswa as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($s['nama']) ?></td>
                            <td><?= htmlspecialchars($s['nis']) ?></td>
                            <td><?= htmlspecialchars($s['kelas']) ?></td>
                            <td><?= htmlspecialchars($mapel) ?></td>
                            <td>
                                <select name="status[<?= $s['nis'] ?>]" class="form-select form-select-sm">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <button type="submit" class="btn btn-success mt-2">Simpan Presensi</button>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>

    <!-- Jurnal Mengajar -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Jurnal Mengajar</div>
        <div class="card-body">
            <form method="POST" id="formJurnal">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Mata Pelajaran</label>
                        <input type="text" name="mapel_jurnal" class="form-control" value="<?= htmlspecialchars($mapel_terakhir) ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas_jurnal" class="form-select" required>
                            <?php foreach ($kelas_list as $k): ?>
                                <option value="<?= $k ?>" <?= $k==$kelas?'selected':'' ?>><?= $k ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Jam Awal</label>
                        <select name="jam_awal" class="form-select" required>
                            <?php for($i=1; $i<=10; $i++): ?>
                                <option><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Jam Akhir</label>
                        <select name="jam_akhir" class="form-select" required>
                            <?php for($i=1; $i<=10; $i++): ?>
                                <option><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Hadir</label>
                        <input type="text" name="hadir" class="form-control" value="<?= $jumlah_hadir ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Tidak Hadir</label>
                        <input type="text" name="tidak_hadir" class="form-control" value="<?= $jumlah_tidak_hadir ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Siswa Tidak Hadir</label>
                    <textarea name="nama_tidak_hadir" class="form-control" rows="3" readonly><?= htmlspecialchars($daftar_tidak_hadir) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kegiatan</label>
                    <textarea name="kegiatan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Materi</label>
                    <textarea name="materi" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Jurnal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('btnSimpanHadir').addEventListener('click', function() {
    // Ambil semua select status
    const statusSelects = document.querySelectorAll('select[name^="status"]');
    statusSelects.forEach(select => {
        select.value = 'Hadir'; // set semua ke Hadir
    });

    // Submit form presensi
    this.closest('form').submit();
});
</script>

</body>
</html>
