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
$tanggal = $_GET['tanggal'] ?? '';

// === AMBIL DATA JURNAL ===
$where = [];
if ($kelas != '') $where[] = "kelas='".mysqli_real_escape_string($koneksi, $kelas)."'";
if ($mapel != '') $where[] = "mapel='".mysqli_real_escape_string($koneksi, $mapel)."'";
if ($tanggal != '') $where[] = "tanggal='".mysqli_real_escape_string($koneksi, $tanggal)."'";

$sql = "SELECT * FROM jurnal_mengajar";
if (count($where) > 0) $sql .= " WHERE " . implode(" AND ", $where);
$sql .= " ORDER BY tanggal DESC, jam_awal ASC";

$query = mysqli_query($koneksi, $sql);
if (!$query) die("Query error: " . mysqli_error($koneksi));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rekap Jurnal Mengajar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; }
header { background-color: #2c3e50; color: white; padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: fixed; top: 0; left: 0; width: 100%; z-index: 10; }
header h1 { font-size: 20px; margin: 0; }
header p { margin: 0; font-size: 14px; opacity: 0.8; }
.logout-btn { background-color: #e74c3c; border: none; color: white; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 14px; transition: 0.3s; }
.logout-btn:hover { background-color: #c0392b; }
.container-custom { max-width: 1300px; background: #fff; border-radius: 15px; padding: 30px; margin: 0 auto 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.table th { background-color: #0d6efd; color: white; }
.back-btn { background-color: #3498db; border: none; color: white; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 14px; transition: 0.3s; }
.back-btn:hover { background-color: #2980b9; }
</style>
</head>
<body>

<header>
  <div>
    <h1>📋 Rekap Jurnal Mengajar</h1>
    <p>Selamat datang, <b><?= $_SESSION['username'] ?? 'Guru'; ?></b></p>
  </div>
  <form action="dashboard.php" method="post">
    <button class="logout-btn">Keluar</button>
  </form>
</header>

<div class="container-custom">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">📝 Rekap Jurnal Mengajar</h4>
    <button class="back-btn" onclick="location.href='dashboard.php'">Kembali ke Dashboard</button>
  </div>

  <!-- Filter -->
<div class="card p-4 shadow-sm mb-4">
  <form method="GET" class="row g-3">
    <div class="col-12">
      <label class="form-label fw-semibold">Kelas</label>
      <select name="kelas" class="form-select">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelas_list as $k): ?>
          <option value="<?= $k ?>" <?= $kelas==$k?'selected':'' ?>><?= $k ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">Mata Pelajaran</label>
      <select name="mapel" class="form-select">
        <option value="">Semua Mapel</option>
        <?php foreach ($mapel_list as $m): ?>
          <option value="<?= $m ?>" <?= $mapel==$m?'selected':'' ?>><?= $m ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">Tanggal</label>
      <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control">
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
    </div>

    <div class="col-12">
      <button type="button" class="btn btn-success w-100" onclick="window.open('cetak_pdf.php?kelas=<?= $kelas ?>&mapel=<?= $mapel ?>&tanggal=<?= $tanggal ?>','_blank')">Cetak PDF</button>
    </div>
  </form>
</div>


  <!-- Tabel Jurnal -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Mapel</th>
          <th>Kelas</th>
          <th>Tanggal</th>
          <th>Jam Awal</th>
          <th>Jam Akhir</th>
          <th>Hadir</th>
          <th>Tidak Hadir</th>
          <th>Nama Tidak Hadir</th>
          <th>Kegiatan</th>
          <th>Materi</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($r = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($r['mapel']) ?></td>
          <td><?= htmlspecialchars($r['kelas']) ?></td>
          <td><?= $r['tanggal'] ?></td>
          <td><?= htmlspecialchars($r['jam_awal']) ?></td>
          <td><?= htmlspecialchars($r['jam_akhir']) ?></td>
          <td><?= $r['hadir'] ?></td>
          <td><?= $r['tidak_hadir'] ?></td>
          <td><?= htmlspecialchars($r['nama_tidak_hadir']) ?></td>
          <td><?= htmlspecialchars($r['kegiatan']) ?></td>
          <td><?= htmlspecialchars($r['materi']) ?></td>
          <td><?= htmlspecialchars($r['keterangan']) ?></td>
          <td>
            <button class="btn btn-sm btn-warning btn-edit" 
                data-id="<?= $r['id'] ?>" 
                data-kelas="<?= $r['kelas'] ?>" 
                data-mapel="<?= $r['mapel'] ?>" 
                data-tanggal="<?= $r['tanggal'] ?>" 
                data-jam_awal="<?= $r['jam_awal'] ?>" 
                data-jam_akhir="<?= $r['jam_akhir'] ?>" 
                data-hadir="<?= $r['hadir'] ?>" 
                data-tidak_hadir="<?= $r['tidak_hadir'] ?>" 
                data-nama_tidak_hadir="<?= htmlspecialchars($r['nama_tidak_hadir'], ENT_QUOTES) ?>" 
                data-kegiatan="<?= htmlspecialchars($r['kegiatan'], ENT_QUOTES) ?>" 
                data-materi="<?= htmlspecialchars($r['materi'], ENT_QUOTES) ?>" 
                data-keterangan="<?= htmlspecialchars($r['keterangan'], ENT_QUOTES) ?>">Ubah</button>
            <button class="btn btn-sm btn-danger btn-hapus" data-id="<?= $r['id'] ?>">Hapus</button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditJurnal">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Jurnal Mengajar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Kelas</label>
              <select name="kelas" id="edit_kelas" class="form-select">
                <?php foreach ($kelas_list as $k): ?>
                  <option value="<?= $k ?>"><?= $k ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Mapel</label>
              <input type="text" name="mapel" id="edit_mapel" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Jam Awal</label>
              <input type="text" name="jam_awal" id="edit_jam_awal" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Jam Akhir</label>
              <input type="text" name="jam_akhir" id="edit_jam_akhir" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Hadir</label>
              <input type="number" name="hadir" id="edit_hadir" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Tidak Hadir</label>
            <input type="text" name="tidak_hadir" id="edit_tidak_hadir" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Tidak Hadir</label>
            <input type="text" name="nama_tidak_hadir" id="edit_nama_tidak_hadir" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <textarea name="kegiatan" id="edit_kegiatan" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Materi</label>
            <textarea name="materi" id="edit_materi" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <a href="#" class="btn btn-danger" id="btnHapusIya">Iya</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    var hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));

    // EDIT
    $('.btn-edit').on('click', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_kelas').val($(this).data('kelas'));
        $('#edit_mapel').val($(this).data('mapel'));
        $('#edit_tanggal').val($(this).data('tanggal'));
        $('#edit_jam_awal').val($(this).data('jam_awal'));
        $('#edit_jam_akhir').val($(this).data('jam_akhir'));
        $('#edit_hadir').val($(this).data('hadir'));
        $('#edit_tidak_hadir').val($(this).data('tidak_hadir'));
        $('#edit_nama_tidak_hadir').val($(this).data('nama_tidak_hadir'));
        $('#edit_kegiatan').val($(this).data('kegiatan'));
        $('#edit_materi').val($(this).data('materi'));
        $('#edit_keterangan').val($(this).data('keterangan'));
        editModal.show();
    });

    $('#formEditJurnal').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: 'update_jurnal.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(resp){
                if(resp.status=="success"){
                    // Update tabel di halaman tanpa reload
                    var id = $('#edit_id').val();
                    var row = $('button.btn-edit[data-id="'+id+'"]').closest('tr');
                    row.find('td:eq(1)').text($('#edit_mapel').val());
                    row.find('td:eq(2)').text($('#edit_kelas').val());
                    row.find('td:eq(3)').text($('#edit_tanggal').val());
                    row.find('td:eq(4)').text($('#edit_jam_awal').val());
                    row.find('td:eq(5)').text($('#edit_jam_akhir').val());
                    row.find('td:eq(6)').text($('#edit_hadir').val());
                    row.find('td:eq(7)').text($('#edit_tidak_hadir').val());
                    row.find('td:eq(8)').text($('#edit_nama_tidak_hadir').val());
                    row.find('td:eq(9)').text($('#edit_kegiatan').val());
                    row.find('td:eq(10)').text($('#edit_materi').val());
                    row.find('td:eq(11)').text($('#edit_keterangan').val());
                    editModal.hide();
                    alert('Data berhasil diperbarui!');
                } else {
                    alert('Error: ' + resp.msg);
                }
            }
        });
    });

    // HAPUS
    $('.btn-hapus').on('click', function() {
        var id = $(this).data('id');
        $('#btnHapusIya').data('id', id);
        hapusModal.show();
    });

    $('#btnHapusIya').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: 'hapus_jurnal.php?id='+id,
            type: 'GET',
            dataType: 'json',
            success: function(resp){
                if(resp.status=="success"){
                    $('button.btn-hapus[data-id="'+id+'"]').closest('tr').remove();
                    hapusModal.hide();
                    alert('Data berhasil dihapus!');
                } else {
                    alert('Error: ' + resp.msg);
                }
            }
        });
    });
});

</script>
</body>
</html>
