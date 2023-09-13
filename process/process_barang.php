<?php
session_start();
include('../config/conn.php');
include('../config/function.php');

if (isset($_POST['tambah'])) {
    $nama_barang      = $_POST['nama_barang'];
    $deskripsi_barang = $_POST['deskripsi_barang'];
    $stok_barang      = $_POST['stok_barang'];
    $harga_barang     = $_POST['harga_barang'];

    $insert = mysqli_query($con, "INSERT INTO tb_barang (nama_barang, deskripsi_barang, harga_barang, stok_awal, stok_barang) VALUES ('$nama_barang','$deskripsi_barang','$harga_barang','$stok_barang','$stok_barang')") or die(mysqli_error($con));
    if ($insert) {
        $success = 'Berhasil menambahkan data barang';
    } else {
        $error = 'Gagal menambahkan data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?barang');
}

//proses ubah
if (isset($_POST['ubah'])) {
    $id               = $_POST['id'];
    $nama_barang      = $_POST['nama_barang'];
    $deskripsi_barang = $_POST['deskripsi_barang'];
    $stok_barang      = $_POST['stok_barang'];
    $harga_barang     = $_POST['harga_barang'];

    $update = mysqli_query($con, "UPDATE tb_barang SET nama_barang='$nama_barang', deskripsi_barang='$deskripsi_barang', harga_barang='$harga_barang', stok_awal='$stok_barang', stok_barang='$stok_barang' WHERE id_barang='$id'") or die(mysqli_error($con));

    // var_dump($update);die;
    if ($update) {
        $success = 'Berhasil mengubah data barang';
    } else {
        $error = 'Gagal mengubah data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?barang');
}


//proses hapus
if (decrypt($_GET['act']) == 'delete' && isset($_GET['id']) != "") {
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM tb_barang WHERE id_barang='$id'") or die(mysqli_error($con));
    if ($query) {
        $success = 'Berhasil menghapus data barang';
    } else {
        $error = 'Gagal menghapus data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?barang');
}

?>