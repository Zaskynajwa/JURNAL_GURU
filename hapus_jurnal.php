<?php
$koneksi = mysqli_connect("localhost","root","","jurnal");
if (!$koneksi) die("Koneksi gagal: ".mysqli_connect_error());

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $query = mysqli_query($koneksi, "DELETE FROM jurnal_mengajar WHERE id=$id");
    if($query){
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error", "msg"=>mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(["status"=>"error","msg"=>"ID tidak ditemukan"]);
}
?>
