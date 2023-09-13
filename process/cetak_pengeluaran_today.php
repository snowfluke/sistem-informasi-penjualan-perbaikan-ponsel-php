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
    <title>Cetak Laporan Pengeluaran</title>
</head>

<body>
    <?php
    $now = date('Y-m-d');
    $query = mysqli_query($con, "SELECT * FROM tb_pengeluaran LEFT JOIN tb_kasir ON tb_kasir.id_kasir = tb_pengeluaran.id_kasir WHERE tanggal='$now' ORDER BY tanggal ASC") or die(mysqli_error($con));

    ?>
    <div style="page-break-after:always;text-align:center;margin-top:5%;">
        <div style="line-height:5px;">
            <h2>LAPORAN PENGELUARAN TERAPI PONSEL</h2>
            <h4>SEMUA PENGELUARAN HARI INI</h4>
        </div>
        <hr style="border-color:black;">
        <table class="tab">
            <tr>
                <th width="20">NO</th>
                <th>TGL</th>
                <th>KEPERLUAN</th>
                <th>DESKRIPSI</th>
                <th>KASIR</th>
                <th>PENGELUARAN</th>
            </tr>
            <?php $n     = 1;
            $total = 0;
            while ($row = mysqli_fetch_array($query)): ?>
                <tr>
                    <td align="center">
                        <?= $n++ . '.'; ?>
                    </td>
                    <td>
                        <?= date('d-m-Y', strtotime($row['tanggal'])); ?>
                    </td>
                    <td>
                        <?= $row['keperluan']; ?>
                    </td>
                    <td>
                        <?= $row['deskripsi']; ?>
                    </td>
                    <td>
                        <?= $row['nama']; ?>
                    </td>
                    <td>
                        <?= $row['total_pengeluaran']; ?>
                    </td>
                </tr>
                <?php
                $total += $row['total_pengeluaran'];
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