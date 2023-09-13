<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $id_kerusakan = $_POST['id_kerusakan'];
    $id_kasir = $_SESSION['id'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $merk_seri_hp =  $_POST['merk_seri_hp'];
    $status_perbaikan = 'belum';
    $tanggal = $_POST['tanggal'];

    $insert = mysqli_query($con,"INSERT INTO tb_perbaikan (id_kerusakan, id_kasir, nama_pelanggan, alamat, no_hp, merk_seri_hp, status_perbaikan, tanggal) VALUES ('$id_kerusakan', '$id_kasir', '$nama_pelanggan', '$alamat', '$no_hp', '$merk_seri_hp', '$status_perbaikan', '$tanggal')") or die (mysqli_error($con));
    if($insert){
        $success = 'Berhasil menambahkan data reparasi';
    }else{
        $error = 'Gagal menambahkan data reparasi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?perbaikan');
}

//proses ubah
if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $id_kerusakan = $_POST['id_kerusakan'];
    $id_kasir = $_SESSION['role'] == 'admin' ? $_POST['id_kasir'] : $_SESSION['id'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $merk_seri_hp =  $_POST['merk_seri_hp'];
    $status_perbaikan = $_POST['status_perbaikan'];
    $tanggal = $_POST['tanggal'];
    $sql = "UPDATE tb_perbaikan SET id_kerusakan='$id_kerusakan', id_kasir='$id_kasir', nama_pelanggan='$nama_pelanggan', alamat='$alamat', no_hp='$no_hp', merk_seri_hp='$merk_seri_hp', tanggal='$tanggal' WHERE id_perbaikan='$id'";

    if($_SESSION['role'] == 'admin'){
        $sql = "UPDATE tb_perbaikan SET id_kerusakan='$id_kerusakan', id_kasir='$id_kasir', nama_pelanggan='$nama_pelanggan', alamat='$alamat', no_hp='$no_hp', merk_seri_hp='$merk_seri_hp', status_perbaikan='$status_perbaikan', tanggal='$tanggal' WHERE id_perbaikan='$id'";
    }

    $update = mysqli_query($con,$sql) or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data reparasi';
    }else{
        $error = 'Gagal mengubah data reparasi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?perbaikan');
}


//proses hapus
if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    if($_SESSION['role'] != 'admin'){
        $_SESSION['error'] = 'Kasir tidak dapat menghapus data!';
        header('Location:../?perbaikan');
    }

    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM tb_perbaikan WHERE id_perbaikan='$id'")or die(mysqli_error($con));
    if($query){
        $success = 'Berhasil menghapus data reparasi';
    }else{
        $error = 'Gagal menghapus data reparasi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?perbaikan');
}

if(decrypt($_GET['act'])=='selesai' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "UPDATE tb_perbaikan SET status_perbaikan='selesai' WHERE id_perbaikan='$id'")or die(mysqli_error($con));
    if($query){
        $success = 'Berhasil menyelesaikan reparasi';
    }else{
        $error = 'Gagal menyelesaikan reparasi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?perbaikan');
}

?>