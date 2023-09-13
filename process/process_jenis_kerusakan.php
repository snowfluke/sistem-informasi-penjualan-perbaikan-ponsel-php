<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $nama_kerusakan = $_POST['nama_kerusakan'];
    $harga_perbaikan = $_POST['harga_perbaikan'];

    $insert = mysqli_query($con,"INSERT INTO tb_jenis_kerusakan (nama_kerusakan, harga_perbaikan) VALUES ('$nama_kerusakan','$harga_perbaikan')") or die (mysqli_error($con));
    if($insert){
        $success = 'Berhasil menambahkan data jenis kerusakan';
    }else{
        $error = 'Gagal menambahkan data jenis kerusakan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jenis_kerusakan');
}

//proses ubah
if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama_kerusakan = $_POST['nama_kerusakan'];
    $harga_perbaikan = $_POST['harga_perbaikan'];

    $update = mysqli_query($con,"UPDATE tb_jenis_kerusakan SET nama_kerusakan='$nama_kerusakan', harga_perbaikan='$harga_perbaikan' WHERE id_kerusakan='$id'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data jenis kerusakan';
    }else{
        $error = 'Gagal mengubah data jenis kerusakan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jenis_kerusakan');
}


//proses hapus
if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM tb_jenis_kerusakan WHERE id_kerusakan='$id'")or die(mysqli_error($con));
    if($query){
        $success = 'Berhasil menghapus data jenis kerusakan';
    }else{
        $error = 'Gagal menghapus data jenis kerusakan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jenis_kerusakan');
}

?>