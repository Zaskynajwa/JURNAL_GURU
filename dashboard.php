<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Presensi</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f6fa;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #2c3e50;
      color: white;
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    header h1 {
      font-size: 22px;
      margin: 0;
    }

    header p {
      margin: 0;
      font-size: 14px;
      opacity: 0.8;
    }

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

    .logout-btn:hover {
      background-color: #c0392b;
    }

    .container {
      padding: 40px 60px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 25px;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      padding: 25px;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    .card-icon {
      font-size: 35px;
      color: #3498db;
      margin-bottom: 10px;
    }

    .card h3 {
      margin: 10px 0 5px;
      color: #2c3e50;
      font-size: 18px;
    }

    .card p {
      color: #7f8c8d;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }
      .container {
        padding: 20px;
      }
    }
  </style>

  <!-- icon fontawesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div>
      <h1>📋 Dashboard Presensi</h1>
      <p>Selamat datang, <b><?php echo $_SESSION['username']; ?></b> (<?= $_SESSION['level']; ?>)</p>
    </div>
    <form action="login.php" method="post">
      <button class="logout-btn">Keluar</button>
    </form>
  </header>

  <div class="container">
    <!-- Tampilkan hanya jika level admin -->
    <?php if ($_SESSION['level'] == 'admin'): ?>
      <div class="card" onclick="location.href='manajemen_siswa.php'">
        <div class="card-icon"><i class="fas fa-users"></i></div>
        <h3>Manajemen Siswa</h3>
        <p>Kelola data siswa</p>
      </div>
    <?php endif; ?>

    <div class="card" onclick="location.href='input_presensi.php'">
      <div class="card-icon"><i class="fas fa-clipboard-check"></i></div>
      <h3>Input Presensi</h3>
      <p>Catat kehadiran siswa</p>
    </div>

    <div class="card" onclick="location.href='rekap_presensi.php'">
      <div class="card-icon"><i class="fas fa-chart-bar"></i></div>
      <h3>Rekap Presensi</h3>
      <p>Lihat data kehadiran</p>
    </div>

    <div class="card" onclick="location.href='rekap_jurnal.php'">
      <div class="card-icon"><i class="fas fa-cog"></i></div>
      <h3>Rekap Jurnal</h3>
      <p>Atur sistem & logout</p>
    </div>
  </div>
</body>
</html>
