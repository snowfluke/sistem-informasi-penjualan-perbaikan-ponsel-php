<?php
session_start();
include ('../config/conn.php');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = mysqli_query($con,"SELECT x.*, x1.nama_barang, x1.harga_barang, x2.nama FROM tb_penjualan x JOIN tb_barang x1 ON x1.id_barang = x.id_barang JOIN tb_kasir x2 ON x2.id_kasir = x.id_kasir WHERE id_penjualan='$id'") or die(mysqli_error($con));
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
}
?>