<?php
// session_start();
include('../config/conn.php');
include('../config/function.php');

$monthNames = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];
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

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }

        .bold {
            font-weight: bold;
        }
    </style>
    <title>Cetak Laporan Keuntungan</title>
</head>

<body>
    <?php
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    $dataPenjualan   = mysqli_query($con, "SELECT DAY(tanggal) AS day, SUM(total_bayar) AS total_penjualan FROM tb_penjualan WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun GROUP BY DAY(tanggal)");
    $dataPerbaikan   = mysqli_query($con, "SELECT DAY(tanggal) AS day, SUM(harga_perbaikan) AS total_perbaikan FROM tb_perbaikan LEFT JOIN tb_jenis_kerusakan ON tb_perbaikan.id_kerusakan = tb_jenis_kerusakan.id_kerusakan WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun GROUP BY DAY(tanggal)");
    $dataPengeluaran = mysqli_query($con, "SELECT DAY(tanggal) AS day, SUM(total_pengeluaran) AS total_pengeluaran FROM tb_pengeluaran WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun GROUP BY DAY(tanggal)");


    $penjualan   = array();
    $perbaikan   = array();
    $pengeluaran = array();

    while ($rowPenjualan = mysqli_fetch_assoc($dataPenjualan)) {
        $penjualan[$rowPenjualan['day']] = $rowPenjualan['total_penjualan'];
    }

    while ($rowPerbaikan = mysqli_fetch_assoc($dataPerbaikan)) {
        $perbaikan[$rowPerbaikan['day']] = $rowPerbaikan['total_perbaikan'];
    }

    while ($rowPengeluaran = mysqli_fetch_assoc($dataPengeluaran)) {
        $pengeluaran[$rowPengeluaran['day']] = $rowPengeluaran['total_pengeluaran'];
    }
    ?>
    <div style="page-break-after:always;text-align:center;margin-top:5%;">
        <div style="line-height:5px;">
            <h2>LAPORAN KEUNTUNGAN TERAPI PONSEL</h2>
            <h4>
                <?= bulan($bulan) ?>
                <?= $tahun ?>
            </h4>
        </div>
        <hr style="border-color:black;">
        <table class="tab">
            <tr>
                <th width="20">TGL</th>
                <th>PENJUALAN</th>
                <th>REPARASI</th>
                <th>PENGELUARAN</th>
                <th>LABA/RUGI</th>
            </tr>
            <?php $n                = 1;
            $totalPenjualan   = 0;
            $totalPerbaikan   = 0;
            $totalPengeluaran = 0;
            $totallabarugi    = 0;

            for ($day = 1; $day <= 31; $day++) {
                if (!isset($penjualan[$day]) && !isset($perbaikan[$day]) && !isset($pengeluaran[$day])) {
                    continue;
                }

                $e_pj = $penjualan[$day] ?? 0;
                $e_pr = $perbaikan[$day] ?? 0;
                $e_pn = $pengeluaran[$day] ?? 0;

                $labrug = ($e_pj + $e_pr) - ($e_pn);
                ?>
                <tr>
                    <td>
                        <?= $day ?>
                    </td>
                    <td>
                        <?= $penjualan[$day] ?? '-' ?>
                    </td>
                    <td>
                        <?= $perbaikan[$day] ?? '-' ?>
                    </td>
                    <td>
                        <?= $pengeluaran[$day] ?? '-' ?>
                    </td>
                    <td class="<?= $labrug >= 0 ? 'text-success' : 'text-danger'; ?>">
                        <?= $labrug; ?>
                    </td>
                </tr>
                <?php
                $totalPenjualan += $e_pj;
                $totalPerbaikan += $e_pr;
                $totalPengeluaran += $e_pn;
                $totallabarugi += $labrug;
            } ?>
            <tr class="bold" style="background-color: yellow;">
                <td align="center"><b>TOTAL</b></td>
                <td>
                    <?= $totalPenjualan; ?>
                </td>
                <td>
                    <?= $totalPerbaikan; ?>
                </td>
                <td>
                    <?= $totalPengeluaran; ?>
                </td>
                <td class="<?= $totallabarugi >= 0 ? 'text-success' : 'text-danger'; ?>">
                    <?= $totallabarugi; ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

<script>
    window.print();
</script>