<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HALAMAN LOGIN MENGGUNAKAN DATABASE PHP MYSQL</title>
  <style>
    /* --- GAYA DASAR HALAMAN --- */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: url('images/images/smk9.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* --- CARD LOGIN --- */
    .kotak-login {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      padding: 40px 30px;
      width: 350px;
      text-align: center;
      backdrop-filter: blur(5px);
    }

    /* --- LOGO --- */
    .logo {
      width: 120px;
      height: 150px;
      margin-bottom: 10px;
    }

    h2 {
      margin: 10px 0 5px 0;
      color: #333;
    }

    h5 {
      color: #666;
      margin-bottom: 25px;
    }

    /* --- INPUT & TOMBOL --- */
    label {
      display: block;
      text-align: left;
      margin-top: 10px;
      font-weight: 600;
      color: #444;
    }

    .form_login {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .klik.login {
      width: 100%;
      padding: 10px;
      background: #2e86de;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 20px;
      transition: background 0.3s;
    }

    .klik.login:hover {
      background: #1b4f9c;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 400px) {
      .kotak-login {
        width: 90%;
        padding: 25px;
      }
    }
  </style>
</head>
<body>
  <div class="kotak-login">
    <img src="images/images/app_logo.png" alt="Logo" class="logo">
    <h2><b>Jurnal Mengajar</b></h2>
    <h5>Silahkan login untuk melanjutkan</h5>

    <form action="ceklogin.php" method="post" role="form">
      <label>Username</label>
      <input type="text" name="username" class="form_login" placeholder="Username" autocomplete="off" required>

      <label>Password</label>
      <input type="password" name="password" class="form_login" placeholder="Password" autocomplete="off" required>

      <input type="submit" class="klik login" value="Login">
    </form>
  </div>
</body>
</html>
