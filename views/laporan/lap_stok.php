<?php hakAkses(['admin', 'kasir']); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Stok</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <form class="col-md-10 row" action="<?= base_url(); ?>process/cetak_stok.php" method="post"
                    target="_blank">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="id_barang">Barang</label>
                            <select name="id_barang" id="id_barang" class="form-control" style="width:100%;" required>
                                <option value="">-- Pilih Barang --</option>
                                <?= list_barang(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 p-2">
                        <button type="submit" class="btn btn-info mt-4"><i class="fas fa-print"></i> Cetak
                            Laporan</button>
                    </div>
                </form>
                <form class="col-md-2 p-2" action="<?= base_url(); ?>process/cetak_stok.php" method="post"
                    target="_blank">
                    <button type="submit" name="all" class="btn btn-success mt-4"><i class="fas fa-print"></i> Cetak
                        Semua</button>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->