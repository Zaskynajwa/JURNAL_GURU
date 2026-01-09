<?php
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// === Daftar bulan dan tahun ===
$bulan_list = [
    "01" => "Januari", "02" => "Februari", "03" => "Maret",
    "04" => "April", "05" => "Mei", "06" => "Juni",
    "07" => "Juli", "08" => "Agustus", "09" => "September",
    "10" => "Oktober", "11" => "November", "12" => "Desember"
];

// === Daftar tahun ===
$tahun_list = [];
$thn_sekarang = date('Y');
for ($i = $thn_sekarang - 5; $i <= $thn_sekarang + 1; $i++) {
    $tahun_list[] = $i;
}

// === Daftar kelas ===
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

$selected_bulan = $_POST['bulan'] ?? date('m');
$selected_tahun = $_POST['tahun'] ?? date('Y');
$selected_kelas = $_POST['kelas'] ?? '';

$data_jurnal = [];
if (isset($_POST['filter'])) {
    $bulan = $selected_bulan;
    $tahun = $selected_tahun;

    $tgl_awal = "$tahun-$bulan-01";
    $tgl_akhir = date("Y-m-t", strtotime($tgl_awal));

    $kelas_filter = $selected_kelas ? "AND kelas = '$selected_kelas'" : '';

    $query = mysqli_query($koneksi, "
        SELECT * FROM jurnal_mengajar 
        WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
        $kelas_filter
        ORDER BY tanggal ASC
    ");

    while ($r = mysqli_fetch_assoc($query)) {
        $data_jurnal[$r['tanggal']][] = $r;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jurnal Mengajar per Hari</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f4f6f9; }
    table { margin-bottom: 40px; font-size: 14px; }
    th, td { text-align: center; vertical-align: middle; }

    .ttd-section {
        margin-top: 60px;
        width: 100%;
    }
    .ttd {
        width: 45%;
        display: inline-block;
        vertical-align: top;
        text-align: center;
    }
    .nama {
        margin-top: 60px;
        text-decoration: underline;
        display: inline-block;
    }
    .nip {
        margin-top: 3px;
    }

    /* Saat print, sembunyikan tombol */
    @media print {
        form, .btn, .no-print {
            display: none !important;
        }
        body {
            background: white;
        }
    }
</style>
</head>
<body>
<div class="container mt-5 mb-5">
    <h3 class="mb-4 fw-bold text-primary">📘 Jurnal Mengajar per Hari</h3>

    <!-- FORM FILTER -->
    <form method="POST" class="row g-3 mb-4 p-3 bg-white rounded shadow-sm">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Bulan</label>
            <select name="bulan" class="form-select" required>
                <?php foreach($bulan_list as $b=>$nama): ?>
                    <option value="<?= $b ?>" <?= $selected_bulan==$b?'selected':'' ?>><?= $nama ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tahun</label>
            <select name="tahun" class="form-select" required>
                <?php foreach($tahun_list as $t): ?>
                    <option value="<?= $t ?>" <?= $selected_tahun==$t?'selected':'' ?>><?= $t ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Semua Kelas</option>
                <?php foreach($kelas_list as $k): ?>
                    <option value="<?= $k ?>" <?= $selected_kelas==$k?'selected':'' ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 align-self-end text-end d-flex gap-2">
            <button type="submit" name="filter" class="btn btn-success flex-fill">Tampilkan Tabel</button>
            <button type="button" onclick="window.print()" class="btn btn-primary flex-fill no-print">Cetak</button>
        </div>
    </form>

    <?php if (isset($_POST['filter'])): ?>
        <?php
        $jumlah_hari = date("t", strtotime("$selected_tahun-$selected_bulan-01"));
        for($hari=1; $hari<=$jumlah_hari; $hari++):
            $tanggal = sprintf("%s-%s-%02d", $selected_tahun, $selected_bulan, $hari);
        ?>
        <h5 class="mt-4 mb-2 fw-semibold text-secondary"><?= date("d-m-Y", strtotime($tanggal)) ?></h5>
        <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Jam</th>
                    <th>Jumlah Hadir</th>
                    <th>Jumlah Tidak Hadir</th>
                    <th>Nama Siswa Tidak Hadir</th>
                    <th>Kegiatan</th>
                    <th>Materi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $jam_rows = [];
            for ($j=1; $j<=10; $j++) {
                $jam_rows[$j] = [
                    'kelas' => '',
                    'hadir' => '',
                    'tidak_hadir' => '',
                    'nama_tidak_hadir' => '',
                    'kegiatan' => '',
                    'materi' => '',
                    'keterangan' => ''
                ];
            }

            if (isset($data_jurnal[$tanggal])) {
                foreach ($data_jurnal[$tanggal] as $entry) {
                    $awal = (int)$entry['jam_awal'];
                    $akhir = (int)$entry['jam_akhir'];
                    for ($j = $awal; $j <= $akhir; $j++) {
                        $jam_rows[$j] = [
                            'kelas' => $entry['kelas'],
                            'hadir' => $entry['hadir'],
                            'tidak_hadir' => $entry['tidak_hadir'],
                            'nama_tidak_hadir' => $entry['nama_tidak_hadir'],
                            'kegiatan' => $entry['kegiatan'],
                            'materi' => $entry['materi'],
                            'keterangan' => $entry['keterangan']
                        ];
                    }
                }
            }

            $no = 1;
            for ($j=1; $j<=10; $j++): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['kelas']) ?></td>
                    <td><?= $j ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['hadir']) ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['tidak_hadir']) ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['nama_tidak_hadir']) ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['kegiatan']) ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['materi']) ?></td>
                    <td><?= htmlspecialchars($jam_rows[$j]['keterangan']) ?></td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
        </div>
        <?php endfor; ?>

        <!-- Bagian tanda tangan -->
        <div class="ttd-section mt-5">
            <div class="ttd text-start">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <div class="nama">(_______________________)</div>
                <div class="nip">NIP. _____________________</div>
            </div>
            <div class="ttd text-end" style="float: right;">
                <p>Semarang, <?= date('d F Y') ?></p>
                <p>Guru Mata Pelajaran</p>
                <div class="nama">(_______________________)</div>
                <div class="nip">NIP. _____________________</div>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
