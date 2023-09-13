<?php
// session_start();
include('../config/conn.php');
include('../config/function.php');
?>
<html>

<head>
    <style>
        h2 {
            padding: 0px;
            margin: 0px;
            font-size: 14pt;
        }

        h4 {
            font-size: 12pt;
        }

        text {
            padding: 0px;
        }

        table {
            border-collapse: collapse;
            border: 1px solid #000;
            font-size: 11pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.tab {
            table-layout: auto;
            width: 100%;
        }
    </style>
    <title>Cetak Laporan Stok</title>
</head>

<body>
    <?php
    $all = isset($_POST['all']) ? true : false;

    $query = "SELECT tb_barang.id_barang, tb_barang.nama_barang, tb_barang.stok_awal, tb_barang.stok_barang, stok_masuk, stok_keluar
    FROM tb_barang
    LEFT JOIN (
        SELECT tb_pengeluaran.id_opsional, SUM(tb_pengeluaran.num_opsional) as stok_masuk 
        FROM tb_pengeluaran 
        GROUP BY tb_pengeluaran.id_opsional
    ) sub_pengeluaran ON tb_barang.id_barang = sub_pengeluaran.id_opsional
    LEFT JOIN (
        SELECT tb_penjualan.id_barang, SUM(tb_penjualan.stok_dijual) AS stok_keluar
        FROM tb_penjualan
        GROUP BY tb_penjualan.id_barang
    ) sub_penjualan ON tb_barang.id_barang = sub_penjualan.id_barang";

    if (!$all) {
        $id_barang = $_POST['id_barang'];

        $query = "SELECT tb_barang.id_barang, tb_barang.nama_barang, tb_barang.stok_awal, tb_barang.stok_barang, stok_masuk, stok_keluar
        FROM tb_barang
        LEFT JOIN (
            SELECT tb_pengeluaran.id_opsional, SUM(tb_pengeluaran.num_opsional) as stok_masuk 
            FROM tb_pengeluaran 
            WHERE tb_pengeluaran.id_opsional = '$id_barang'
            GROUP BY tb_pengeluaran.id_opsional
        ) sub_pengeluaran ON tb_barang.id_barang = sub_pengeluaran.id_opsional
        LEFT JOIN (
            SELECT tb_penjualan.id_barang, SUM(tb_penjualan.stok_dijual) AS stok_keluar
            FROM tb_penjualan
            WHERE tb_penjualan.id_barang = '$id_barang'
            GROUP BY tb_penjualan.id_barang
        ) sub_penjualan ON tb_barang.id_barang = sub_penjualan.id_barang WHERE tb_barang.id_barang = '$id_barang'";
    }

    $el_barang = mysqli_query($con, $query) or die(mysqli_error($con));

    ?>
    <div style="page-break-after:always;text-align:center;margin-top:5%;">
        <div style="line-height:5px;">
            <h2>LAPORAN STOK BARANG TERAPI PONSEL</h2>
            <h4>
            </h4>
        </div>
        <hr style="border-color:black;">
        <table class="tab">
            <tr>
                <th width="20">NO</th>
                <th>NAMA BARANG</th>
                <th>STOK AWAL</th>
                <th>STOK TERJUAL</th>
                <th>STOK MASUK</th>
                <th>JUMLAH</th>
            </tr>
            <?php $n     = 1;
            $total = 0;
            while ($row = mysqli_fetch_array($el_barang)): ?>
                <tr>
                    <td align="center">
                        <?= $n++ . '.'; ?>
                    </td>
                    <td>
                        <?= $row['nama_barang']; ?>
                    </td>
                    <td>
                        <?= $row['stok_awal']; ?>
                    </td>
                    <td>
                        <?= $row['stok_keluar']; ?>
                    </td>
                    <td>
                        <?= $row['stok_masuk']; ?>
                    </td>
                    <td>
                        <?= $row['stok_barang'] ?>
                    </td>
                </tr>
                <?php
                $total += $row['stok_barang'];
            endwhile; ?>
            <tr>
                <td colspan="5" align="center"><b>TOTAL</b></td>
                <td>
                    <?= $total; ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

<script>
    window.print();
</script>