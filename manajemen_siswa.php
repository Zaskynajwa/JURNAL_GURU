<?php
date_default_timezone_set('Asia/Jakarta');

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Simpan data baru
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $jk = $_POST['Jenis_Kelamin'];
    $kelas = $_POST['kelas'];

    $query = "INSERT INTO admin (nama, nis, jenis_kelamin, kelas, waktu_simpan)
              VALUES ('$nama', '$nis', '$jk', '$kelas', NOW())";
    mysqli_query($koneksi, $query);
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nis_baru = $_POST['nis'];
    $jk = $_POST['Jenis_Kelamin'];
    $kelas = $_POST['kelas'];

    $query = "UPDATE admin 
              SET nama='$nama', nis='$nis_baru', jenis_kelamin='$jk', kelas='$kelas'
              WHERE nis='$id'";
    mysqli_query($koneksi, $query);
}

// Filter kelas
$filter_kelas = "";
if (isset($_GET['filter_kelas']) && $_GET['filter_kelas'] != "") {
    $filter_kelas = $_GET['filter_kelas'];
    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE kelas='$filter_kelas' ORDER BY nama ASC");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY nama ASC");
}

// Daftar kelas
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
  <h2 class="text-center mb-4 fw-bold text-primary">Manajemen Siswa</h2>

  <!-- FORM INPUT -->
  <form action="" method="post" class="mb-5 p-4 bg-white rounded-4 shadow-sm border">
    <h5 class="mb-3 fw-semibold text-secondary">Form Input Data Siswa</h5>

    <div class="mb-3">
      <label class="form-label fw-semibold">Nama</label>
      <input type="text" name="nama" class="form-control rounded-3" placeholder="Masukkan nama siswa" required>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">NIS</label>
      <input type="text" name="nis" class="form-control rounded-3" placeholder="Masukkan NIS" required>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Jenis Kelamin</label>
      <select name="Jenis_Kelamin" class="form-select rounded-3" required>
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold">Kelas</label>
      <select name="kelas" class="form-select rounded-3" required>
        <option value="">Pilih Kelas</option>
        <?php foreach ($kelas_list as $k): ?>
          <option value="<?= $k ?>"><?= $k ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary w-100 rounded-3">Simpan</button>
  </form>

  <!-- FILTER KELAS -->
  <div class="mb-4 p-3 bg-white rounded-4 shadow-sm border">
    <label for="filter_kelas" class="form-label fw-semibold">Tampilkan berdasarkan kelas:</label>
    <select name="filter_kelas" id="filter_kelas" class="form-select rounded-3" onchange="this.form.submit()">
      <option value="">Semua Kelas</option>
      <?php foreach ($kelas_list as $k): 
        $selected = ($filter_kelas == $k) ? "selected" : "";
        echo "<option value='$k' $selected>$k</option>";
      endforeach; ?>
    </select>
  </div>

  <!-- TABEL DATA -->
  <div class="bg-white p-3 rounded-4 shadow-sm border">
    <h5 class="mb-3 fw-semibold text-secondary">Data Siswa</h5>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle text-center mb-0">
        <thead class="table-primary text-center text-white rounded-3">
          <tr>
            <th>Nama</th>
            <th>NIS</th>
            <th>Jenis Kelamin</th>
            <th>Kelas</th>
            <th>Waktu Simpan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>{$row['nama']}</td>
                      <td>{$row['nis']}</td>
                      <td>{$row['jenis_kelamin']}</td>
                      <td>{$row['kelas']}</td>
                      <td>{$row['waktu_simpan']}</td>
                      <td>
                        <button 
                          class='btn btn-outline-warning btn-sm rounded-3 editBtn'
                          data-id='{$row['nis']}'
                          data-nama='{$row['nama']}'
                          data-jk='{$row['jenis_kelamin']}'
                          data-kelas='{$row['kelas']}'
                        >Edit</button>
                        
                        <button 
                          class='btn btn-outline-danger btn-sm rounded-3 deleteBtn'
                          data-id='{$row['nis']}'
                        >Hapus</button>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data siswa.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="">
        <div class="modal-header bg-warning">
          <h5 class="modal-title">Edit Data Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">

          <div class="mb-3">
            <label>Nama:</label>
            <input type="text" name="nama" id="edit-nama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>NIS:</label>
            <input type="text" name="nis" id="edit-nis" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Jenis Kelamin:</label>
            <select name="Jenis_Kelamin" id="edit-jk" class="form-select" required>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Kelas:</label>
            <select name="kelas" id="edit-kelas" class="form-select" required>
              <?php foreach ($kelas_list as $k): ?>
                <option value="<?= $k ?>"><?= $k ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Anda yakin akan menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <a href="#" id="confirmDelete" class="btn btn-danger">Yakin</a>
      </div>
    </div>
  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// === Modal Edit ===
document.querySelectorAll('.editBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-nama').value = btn.dataset.nama;
    document.getElementById('edit-jk').value = btn.dataset.jk;
    document.getElementById('edit-kelas').value = btn.dataset.kelas;
    document.getElementById('edit-nis').value = btn.dataset.id;
    new bootstrap.Modal(document.getElementById('editModal')).show();
  });
});

// === Modal Hapus ===
document.querySelectorAll('.deleteBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    const nis = btn.dataset.id;
    const confirmDelete = document.getElementById('confirmDelete');
    confirmDelete.href = "hapus.php?nis=" + nis;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
  });
});
</script>

</body>
</html>
