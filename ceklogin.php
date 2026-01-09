<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if ($data) {
  $_SESSION['username'] = $data['username'];
  $_SESSION['level'] = $data['level']; // simpan level user
  header("Location: dashboard.php");
  exit();
} else {
  echo "<script>
  alert('Username atau password salah!');
  window.location='login.php';
  </script>";
}
?>
