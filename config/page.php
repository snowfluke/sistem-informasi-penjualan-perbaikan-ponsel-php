<?php
if (isset($_GET['backup_app'])) {
    include('proses/backup_app.php');
} else if (isset($_GET['backup_db'])) {
    include('proses/backup_db.php');
} else if (isset($_GET['kasir'])) {
    $master = $kasir = true;
    $views = 'views/master/kasir.php';
} else if (isset($_GET['barang'])) {
    $master = $barang = true;
    $views = 'views/master/barang.php';
} else if (isset($_GET['jenis_kerusakan'])) {
    $master = $jenis_kerusakan = true;
    $views = 'views/master/jenis_kerusakan.php';
} else if (isset($_GET['penjualan'])) {
    $transaksi = $penjualan = true;
    $views = 'views/transaksi/penjualan.php';
} else if (isset($_GET['pengeluaran'])) {
    $transaksi = $pengeluaran = true;
    $views = 'views/transaksi/pengeluaran.php';
} else if (isset($_GET['perbaikan'])) {
    $transaksi = $perbaikan = true;
    $views = 'views/transaksi/perbaikan.php';
} else if (isset($_GET['lap_penjualan'])) {
    $laporan = $lap_penjualan = true;
    $views = 'views/laporan/lap_penjualan.php';
} else if (isset($_GET['lap_perbaikan'])) {
    $laporan = $lap_perbaikan = true;
    $views = 'views/laporan/lap_perbaikan.php';
} else if (isset($_GET['lap_pengeluaran'])) {
    $laporan = $lap_pengeluaran = true;
    $views = 'views/laporan/lap_pengeluaran.php';
} else if (isset($_GET['lap_keuntungan'])) {
    $laporan = $lap_keuntungan = true;
    $views = 'views/laporan/lap_keuntungan.php';
} else if (isset($_GET['lap_stok'])) {
    $laporan = $lap_stok = true;
    $views = 'views/laporan/lap_stok.php';
} else {
    $home  = true;
    $views = 'views/home.php';
}
?>