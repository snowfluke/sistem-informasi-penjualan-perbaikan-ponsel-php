<?php hakAkses(['admin', 'kasir']);
$currentYear = date('Y');
$startYear   = $currentYear - 2;
$endYear     = $currentYear + 2;

$currentMonth = date('n');
$monthList    = [
    '1'  => 'Januari',
    "2"  => "Februari",
    "3"  => "Maret",
    "4"  => "April",
    "5"  => "Mei",
    "6"  => "Juni",
    "7"  => "Juli",
    "8"  => "Agustus",
    "9"  => "September",
    "10" => "Oktober",
    "11" => "November",
    "12" => "Desember"
]
    ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuntungan</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url(); ?>process/cetak_keuntungan.php" method="post" target="_blank">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control" style="width:100%;" required>

                                <?php
                                foreach ($monthList as $monthNumber => $monthName) {
                                    ?>
                                    <option <?= ($currentMonth == $monthNumber) ? 'selected' : '' ?>
                                        value="<?= $monthNumber ?>">
                                        <?= $monthName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control" style="width:100%;" required>
                                <?php
                                for ($year = $startYear; $year <= $endYear; $year++) {
                                    ?>
                                    <option <?= $year == $currentYear ? 'selected' : '' ?> value="<?= $year ?>"><?= $year ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 p-2">
                        <button type="submit" class="btn btn-info mt-4"><i class="fas fa-print"></i> Cetak
                            Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->