<?php
session_start();
include('../config/conn.php');
include('../config/function.php');

if (isset($_POST['tambah'])) {
    $id_kasir          = $_SESSION['id'];
    $keperluan         = $_POST['keperluan'];
    $deskripsi         = $_POST['deskripsi'];
    $total_pengeluaran = $_POST['total_pengeluaran'];
    $bukti             = $_FILES['bukti'];
    $tanggal           = $_POST['tanggal'];

    $id_barang    = $_POST['id_barang'];
    $tambah_stok  = $_POST['tambah_stok'];
    $id_opsional  = 0;
    $num_opsional = 0;

    if ($keperluan == 'RESTOK') {
        $queryBarang  = mysqli_query($con, "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'");
        $row          = mysqli_fetch_array($queryBarang);
        $deskripsi    = "Restok " . $row['nama_barang'] . " (" . $tambah_stok . ")";
        $id_opsional  = $id_barang;
        $num_opsional = $tambah_stok;
    }


    $namaFile      = $tanggal . "-" . $id_kasir . "-" . generateUniqueCode() . "-" . $bukti['name'];
    $namaSementara = $bukti['tmp_name'];
    $dirUpload     = "../bukti/";

    $terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);

    if (!$terupload) {
        $_SESSION['error'] = "Gagal mengupload bukti pengeluaran";
        header('Location:../?pengeluaran');
        return;
    }

    mysqli_autocommit($con, false);
    $query_success = true;

    $insert = mysqli_query($con, "INSERT INTO tb_pengeluaran (id_kasir, keperluan, id_opsional, num_opsional, deskripsi, total_pengeluaran,bukti, tanggal) VALUES ('$id_kasir', '$keperluan', '$id_opsional', '$num_opsional', '$deskripsi', '$total_pengeluaran', '$namaFile', '$tanggal')") or die(mysqli_error($con));

    if (!$insert) {
        $query_success = false;
    }

    if ($keperluan == 'RESTOK') {
        $update_stok = mysqli_query($con, "UPDATE tb_barang SET stok_barang = tb_barang.stok_barang + $tambah_stok WHERE id_barang = '$id_barang'");

        if (!$update_stok) {
            $query_success = false;
        }
    }

    if ($query_success) {
        mysqli_commit($con);
        mysqli_autocommit($con, true);
        $success = 'Berhasil menambahkan data pengeluaran';
    } else {
        mysqli_rollback($con);
        mysqli_autocommit($con, true);
        $error = 'Gagal menambahkan data pengeluaran';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?pengeluaran');
}


//proses hapus
if (decrypt($_GET['act']) == 'delete' && isset($_GET['id']) != "") {
    if ($_SESSION['role'] != 'admin') {
        $_SESSION['error'] = 'Kasir tidak dapat menghapus data!';
        header('Location:../?pengeluaran');
    }

    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM tb_pengeluaran WHERE id_pengeluaran='$id'") or die(mysqli_error($con));
    if ($query) {
        $success = 'Berhasil menghapus data pengeluaran';
    } else {
        $error = 'Gagal menghapus data pengeluaran';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error']   = $error;
    header('Location:../?pengeluaran');
}

?>