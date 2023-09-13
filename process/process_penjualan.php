<?php
session_start();
include('../config/conn.php');
include('../config/function.php');

if (isset($_POST['tambah'])) {
    $id_barang    = $_POST['id_barang'];
    $id_kasir     = $_SESSION['id'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $stok_dijual  = $_POST['stok_dijual'];
    $total_bayar  = $_POST['total_bayar'];
    $tanggal      = $_POST['tanggal'];

    $get_stok     = mysqli_query($con, "SELECT stok_barang FROM tb_barang WHERE id_barang = '$id_barang'");
    $current_stok = mysqli_fetch_array($get_stok);

    if ($stok_dijual > $current_stok['stok_barang']) {
        $_SESSION['error'] = 'Melebihi stok yang tersedia!';
        header('Location:../?penjualan');
        return;
    }

    mysqli_autocommit($con, false);
    $query_success = true;

    $insert = mysqli_query($con, "INSERT INTO tb_penjualan (id_barang, id_kasir, nama_pembeli, stok_dijual, total_bayar, tanggal) VALUES ('$id_barang', '$id_kasir', '$nama_pembeli', '$stok_dijual', '$total_bayar', '$tanggal')") or die(mysqli_error($con));

    if (!$insert) {
        $query_success = false;
    }

    $update_stok = mysqli_query($con, "UPDATE tb_barang SET stok_barang = tb_barang.stok_barang - $stok_dijual WHERE id_barang = '$id_barang'");

    if (!$update_stok) {
        $query_success = false;
    }

    if ($query_success) {
        mysqli_commit($con);
        mysqli_autocommit($con, true);
        $success = 'Berhasil menambahkan data penjualan';
    } else {
        mysqli_rollback($con);
        mysqli_autocommit($con, true);
        $error = 'Gagal menambahkan data penjualan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?penjualan');
}

//proses ubah
if (isset($_POST['ubah'])) {
    $id                = $_POST['id'];
    $id_barang         = $_POST['id_barang'];
    $id_kasir          = $_SESSION['role'] == 'admin' ? $_POST['id_kasir'] : $_SESSION['id'];
    $nama_pembeli      = $_POST['nama_pembeli'];
    $stok_dijual       = $_POST['stok_dijual'];
    $stok_dijual_lawas = $_POST['stok_dijual_lawas'];
    $total_bayar       = $_POST['total_bayar'];
    $tanggal           = $_POST['tanggal'];

    $get_stok         = mysqli_query($con, "SELECT stok_barang FROM tb_barang WHERE id_barang = '$id_barang'");
    $current_stok     = mysqli_fetch_array($get_stok);
    $renormalize_stok = $stok_dijual_lawas + $current_stok['stok_barang'];

    if ($stok_dijual > $renormalize_stok) {
        $_SESSION['error'] = 'Melebihi stok yang tersedia!';
        header('Location:../?penjualan');
        return;
    }
    mysqli_autocommit($con, false);
    $query_success = true;

    $update = mysqli_query($con, "UPDATE tb_penjualan SET id_barang='$id_barang', id_kasir='$id_kasir', nama_pembeli='$nama_pembeli', stok_dijual='$stok_dijual', total_bayar='$total_bayar', tanggal='$tanggal' WHERE id_penjualan='$id'") or die(mysqli_error($con));
    if (!$update) {
        $query_success = false;
    }

    $update_stok = mysqli_query($con, "UPDATE tb_barang SET stok_barang = $renormalize_stok - $stok_dijual WHERE id_barang = '$id_barang'");

    if (!$update_stok) {
        $query_success = false;
    }

    if ($query_success) {
        mysqli_commit($con);
        mysqli_autocommit($con, true);
        $success = 'Berhasil mengubah data penjualan';
    } else {
        mysqli_rollback($con);
        mysqli_autocommit($con, true);
        $error = 'Gagal mengubah data penjualan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?penjualan');
}


//proses hapus
if (decrypt($_GET['act']) == 'delete' && isset($_GET['id']) != "") {
    if ($_SESSION['role'] != 'admin') {
        $_SESSION['error'] = 'Kasir tidak dapat menghapus data!';
        header('Location:../?penjualan');
    }

    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM tb_penjualan WHERE id_penjualan='$id'") or die(mysqli_error($con));
    if ($query) {
        $success = 'Berhasil menghapus data penjualan';
    } else {
        $error = 'Gagal menghapus data penjualan';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?penjualan');
}

?>