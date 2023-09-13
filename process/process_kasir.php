<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password =  $_POST['password'];
    $role = 'kasir';

    $cek = mysqli_query($con,"SELECT * FROM tb_kasir WHERE username='$username'") or die(mysqli_error($con));
    if(mysqli_num_rows($cek)==0){
        $insert = mysqli_query($con,"INSERT INTO tb_kasir (nama, username, password, role) VALUES ('$nama','$username','$password','$role')") or die (mysqli_error($con));
        if($insert){
            $success = 'Berhasil menambahkan data kasir';
        }else{
            $error = 'Gagal menambahkan data kasir';
        }
    }else{
        $error = 'Kasir telah terdaftar !';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?kasir');
}
if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    if($password!=""){
        $update = mysqli_query($con,"UPDATE tb_kasir SET nama='$nama', password='$password' WHERE id_kasir='$id'") or die (mysqli_error($con));
    }else{
        $update = mysqli_query($con,"UPDATE tb_kasir SET nama='$nama' WHERE id_kasir='$id'") or die (mysqli_error($con));
    }
    if($update){
        $success = 'Berhasil mengubah data kasir';
    }else{
        $error = 'Gagal mengubah data kasir';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?kasir');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM tb_kasir WHERE id_kasir='$id'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data kasir berhasil dihapus";
    }else{
        $error = "Data kasir gagal dihapus";
    }
    $_SESSION['success'] = $success;
    header('Location:../?kasir');
}

if(decrypt($_GET['act'])=='ganti_pass' && isset($_POST['ubah_pass'])){
    $id = $_POST['id'];
    $password = $_POST['password'];

    $update = mysqli_query($con,"UPDATE tb_kasir SET password='$password' WHERE id_kasir='$id'") or die (mysqli_error($con));
    $_SESSION['success'] = "Anda berhasil mengubah password";
    echo '<script>window.history.back();</script>';
}

?>