<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "jurnal";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
