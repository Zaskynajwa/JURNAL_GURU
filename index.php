<?php
// index.php — Halaman utama Jurnal Guru
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jurnal Guru</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      scroll-behavior: smooth;
    }

    body {
      background: url('images/images/smk9.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
      overflow-x: hidden;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.55);
      z-index: -1;
    }

    /* === Navbar === */
    nav {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(255, 140, 0, 0.1);
      backdrop-filter: blur(12px);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 70px;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #ff9800;
    }

    .logo h1 {
      font-size: 26px;
      font-weight: 700;
      background: linear-gradient(90deg, #ff0000, #ff8c00, #ffeb3b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      padding: 8px 15px;
      border-radius: 25px;
      transition: all 0.3s ease;
    }

    nav ul li a:hover {
      background: linear-gradient(45deg, #ff0000, #ff9800, #ffeb3b);
      color: #111;
      font-weight: 600;
      box-shadow: 0 0 15px rgba(255, 152, 0, 0.6);
    }

    /* === Section === */
    section {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 120px 20px;
      text-align: center;
      opacity: 0;
      transform: translateY(50px);
      transition: all 1s ease;
    }

    section.visible {
      opacity: 1;
      transform: translateY(0);
    }

    section h2 {
      font-size: 48px;
      margin-bottom: 20px;
      background: linear-gradient(90deg, #ff0000, #ff9800, #ffeb3b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    section p {
      font-size: 18px;
      max-width: 800px;
      color: #f3f3f3;
      line-height: 1.7;
    }

    /* === About (Jurnal) === */
    .about {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      padding: 60px 40px;
      margin: 60px 0;
      box-shadow: 0 0 25px rgba(255, 87, 34, 0.3);
      backdrop-filter: blur(10px);
      position: relative;
      overflow: hidden;
    }

    .carousel-container {
      width: 100%;
      overflow: hidden;
      margin-top: 30px;
      border-radius: 15px;
    }

    .carousel {
      display: flex;
      gap: 20px;
      animation: slide 25s linear infinite;
    }

    .carousel img {
      width: 350px;
      height: 220px;
      border-radius: 15px;
      object-fit: cover;
      box-shadow: 0 0 15px rgba(255, 152, 0, 0.5);
      transition: transform 0.3s ease;
    }

    .carousel img:hover {
      transform: scale(1.08);
    }

    @keyframes slide {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    /* === Contact === */
    .contact {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      padding: 60px 40px;
      box-shadow: 0 0 25px rgba(255, 87, 34, 0.3);
      backdrop-filter: blur(10px);
    }

    .contact a {
      color: #ffeb3b;
      text-decoration: none;
      font-weight: 600;
    }

    .contact a:hover {
      text-decoration: underline;
    }

    /* === Tombol Login === */
    .btn-login {
      margin-top: 30px;
      padding: 12px 35px;
      background: linear-gradient(90deg, #ff0000, #ff9800, #ffeb3b);
      border: none;
      border-radius: 30px;
      font-size: 16px;
      color: #111;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-login:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(255, 193, 7, 0.6);
    }

    footer {
      background: rgba(0, 0, 0, 0.6);
      text-align: center;
      padding: 25px;
      color: #ffeb3b;
      font-size: 15px;
    }

    /* Responsif */
    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        gap: 10px;
        padding: 10px 20px;
      }

      .carousel img {
        width: 250px;
        height: 160px;
      }

      section h2 {
        font-size: 34px;
      }

      section p {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <!-- === Navbar === -->
  <nav>
    <div class="logo">
      <img src="images/images/app_logo.png" alt="Logo Jurnal Guru">
      <h1>Jurnal Guru</h1>
    </div>
    <ul>
      <li><a href="#beranda">Beranda</a></li>
      <li><a href="#about">Jurnal</a></li>
      <li><a href="#contact">Contact</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>

  <!-- === Beranda === -->
  <section id="beranda">
    <h2>Selamat Datang di Jurnal Guru</h2>
    <p>
      Platform digital untuk membantu guru mencatat dan mengelola kegiatan mengajar dengan cepat, efisien, dan rapi.
      Nikmati kemudahan administrasi kelas dalam satu sistem terpadu.
    </p>
    <button class="btn-login" onclick="location.href='login.php'">Mulai Sekarang</button>
  </section>

  <!-- === About (Jurnal) === -->
  <section id="about" class="about">
    <h2>Tentang Web Jurnal Guru</h2>
    <p>
      <strong>Jurnal Guru</strong> adalah aplikasi berbasis web yang digunakan untuk mencatat kegiatan pembelajaran guru di sekolah.  
      Website ini bermanfaat untuk membantu guru:
      <br><br>
      ✅ Mencatat kehadiran siswa dan aktivitas kelas secara digital. <br>
      ✅ Memudahkan pembuatan laporan harian dan bulanan. <br>
      ✅ Menyimpan data kegiatan mengajar dengan rapi. <br>
      ✅ Meningkatkan efisiensi administrasi pendidikan. <br>
      ✅ Memberikan kemudahan akses dari berbagai perangkat.
    </p>

    <div class="carousel-container">
      <div class="carousel">
        <img src="images/images/1.jpg" alt="Guru 1">
        <img src="images/images/apa-itu-web-development-adalah.jpg" alt="Guru 2">
        <img src="images/images/E5385D1C-81F2-440B-BA5D-3BC00EB59E55-1024x576.jpeg" alt="Guru 3">
        <img src="images/images/kuota-indosat-pjj.jpg" alt="Guru 4">
        <img src="images/images/strategi-mengajar-yang-efektif.jpg" alt="Guru 5">
        <!-- duplikasi untuk loop efek halus -->
        <img src="images/images/1.jpg" alt="Guru 1">
        <img src="images/images/apa-itu-web-development-adalah.jpg" alt="Guru 2">
        <img src="images/images/E5385D1C-81F2-440B-BA5D-3BC00EB59E55-1024x576.jpeg" alt="Guru 3">
        <img src="images/images/kuota-indosat-pjj.jpg" alt="Guru 4">
        <img src="images/images/strategi-mengajar-yang-efektif.jpg" alt="Guru 5">
      </div>
    </div>
  </section>

  <!-- === Contact === -->
  <section id="contact" class="contact">
    <h2>Hubungi Kami</h2>
    <p>
      Ada pertanyaan, ide, atau saran? Kami siap mendengarkan!<br>
      Hubungi kami melalui email di bawah ini:
    </p>
    <p>Email: <a href="mailto:jurnalguru@gmail.com">jurnalguru@gmail.com</a></p>
  </section>

  <footer>
    © 2025 Jurnal Guru | SMKN 9 Semarang
  </footer>

  <script>
    // animasi scroll
    const sections = document.querySelectorAll('section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.2 });
    sections.forEach(s => observer.observe(s));
  </script>

</body>
</html>
