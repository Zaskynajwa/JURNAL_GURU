<?php
$koneksi = mysqli_connect("localhost", "root", "", "jurnal");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $JK = $_POST['JK'];
    $kelas = $_POST['kelas'];
    $simpan = $_POST['simpan'];

    $query = "INSERT INTO admin (nama, nis, jenis_kelamin, kelas, waktu_simpan)
          VALUES ('$nama', '$nis', '$jk', '$kelas', NOW())";
    mysqli_query($koneksi, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Siswa</title>
</head>
<body>
    <h2>Form Input Data Siswa</h2>
    <form method="POST">
        Nama: <input type="text" name="nama" required><br><br>
        NIS: <input type="text" name="nis" required><br><br>
        Jenis Kelamin:
        <select name="JK" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br><br>
        Kelas: <input type="text" name="kelas" required><br><br>
        <input type="submit" name="simpan" value="Simpan">
    </form>

    <hr>
    <h3>Data Siswa</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Nama</th>
            <th>NIS</th>
            <th>Jenis Kelamin</th>
            <th>Kelas</th>
        </tr>

        <?php
        // Tampilkan semua data dari tabel
        $result = mysqli_query($koneksi, "SELECT * FROM admin");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['nis']}</td>
                    <td>{$row['jenis_kelamin']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['waktu_simpan']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
