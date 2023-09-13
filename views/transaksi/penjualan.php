<?php hakAkses(['admin', 'kasir']); ?>
<script>
    function submit(x, id_kasir) {
        if (x == 'add') {
            $('#penjualanModal .modal-title').html('Tambah penjualan');
            $('[name="id_barang"]').val("").trigger('change');
            $('[name="tanggal"]').val("").trigger('change');
            $('[name="nama_pembeli"]').val("").trigger('change');
            $('[name="stok_dijual"]').val("").trigger('change');
            $('[name="harga_barang"]').val("").trigger('change');
            $('[name="id_kasir"]').val(id_kasir);
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#penjualanModal .modal-title').html('Edit penjualan');
            $('[name="id_barang"]').val("").trigger('change');
            $('[name="id_kasir"]').val('change');
            $('[name="tanggal"]').val("").trigger('change');
            $('[name="nama_pembeli"]').val("").trigger('change');
            $('[name="stok_dijual"]').val("").trigger('change');
            $('[name="harga_barang"]').val("").trigger('change');
            $('[name="tambah"]').hide();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_penjualan.php',
                dataType: 'json',
                success: function (data) {
                    $('[name="id"]').val(data.id_penjualan);
                    $('[name="tanggal"]').val(data.tanggal);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="id_kasir"]').val(data.id_kasir);
                    $('[name="id_barang"]').val(data.id_barang);
                    $('[name="stok_dijual"]').val(data.stok_dijual);
                    $('[name="stok_dijual_lawas"]').val(data.stok_dijual);
                    $('[name="nama_pembeli"]').val(data.nama_pembeli);
                    $('[name="total_bayar"]').val(parseInt(data.harga_barang) * parseInt(data.stok_dijual));
                    $('[name="deskripsi_barang"]').val(data.deskripsi_barang);
                }
            });
        }

        function calculatePrice() {
            let selectedOption = $('#id_barang').find("option:selected");
            let hargaBarang = selectedOption.data("harga-barang")
            let jumlah = $('[name="stok_dijual"]').val()
            if (isNaN(hargaBarang) || isNaN(jumlah) || !jumlah || !hargaBarang) {
                $('[name="total_bayar"]').val(parseInt(0));
                return
            }
            let total = parseInt(jumlah) * parseInt(hargaBarang)
            $('[name="total_bayar"]').val(total);
        }

        $(document).ready(function () {
            $("#id_barang").on("change", calculatePrice);
            $('[name="stok_dijual"]').on("change", calculatePrice);
        })
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penjualan</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#penjualanModal"
                onclick="submit('add', '<?= $_SESSION['id'] ?>')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
            <a href="<?= base_url(); ?>process/cetak_penjualan_today.php" target="_blank"
                class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak penjualan hari ini</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5">NO</th>
                            <th>TANGGAL</th>
                            <th>BARANG</th>
                            <th>JML</th>
                            <th>PEMBELI</th>
                            <th>KASIR</th>
                            <th>HARGA</th>
                            <th>TOTAL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT x.*, x1.nama_barang, x1.harga_barang, x2.nama FROM tb_penjualan x JOIN tb_barang x1 ON x1.id_barang = x.id_barang JOIN tb_kasir x2 ON x2.id_kasir = x.id_kasir ORDER BY x.tanggal ASC") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($query)):
                            ?>
                            <tr>
                                <td>
                                    <?= $n++; ?>
                                </td>
                                <td>
                                    <?= date('d-m-Y', strtotime($row['tanggal'])); ?>
                                </td>
                                <td>
                                    <?= $row['nama_barang']; ?>
                                </td>
                                <td>
                                    <?= $row['stok_dijual']; ?>
                                </td>
                                <td>
                                    <?= $row['nama_pembeli']; ?>
                                </td>
                                <td>
                                    <?= $row['nama']; ?>
                                </td>
                                <td>
                                    <?= $row['harga_barang']; ?>
                                </td>
                                <td>
                                    <?= ($row['stok_dijual'] * $row['harga_barang']); ?>
                                </td>
                                <td>
                                    <div class="d-inline-flex p-2">
                                        <a href="#penjualanModal" data-toggle="modal"
                                            onclick="submit(<?= $row['id_penjualan']; ?>)"
                                            class="btn btn-sm btn-circle btn-info mr-2"><i class="fas fa-edit"></i></a>
                                        <?php if ($_SESSION['role'] == 'admin'): ?>
                                            <a href="<?= base_url(); ?>/process/process_penjualan.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['id_penjualan']); ?>"
                                                class="btn btn-sm btn-circle btn-danger btn-hapus"><i
                                                    class="fas fa-trash"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Penjualan -->
<div class="modal fade" id="penjualanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/process_penjualan.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                <input type="hidden" name="id" class="form-control">
                                <input type="hidden" name="stok_dijual_lawas" class="form-control">
                                <input type="hidden" name="id_kasir" value="<?= $_SESSION['id'] ?>"
                                    class="form-control">
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Kasir</label>
                                <select name="id_kasir" id="id_kasir" class="form-control" style="width:100%;"
                                    <?= $_SESSION['role'] != 'admin' ? 'readonly disabled' : ''; ?> required>
                                    <option value="">-- Pilih Kasir --</option>
                                    <?= list_kasir(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_barang">Nama Barang <span class="text-danger">*</span></label>
                                <select name="id_barang" id="id_barang" class="form-control" style="width:100%;"
                                    required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?= list_barang(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pembeli">Nama Pembeli<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok_dijual">Jumlah beli<span class="text-danger">*</span></label>
                                <input type="text" class="form-control uang" id="stok_dijual" name="stok_dijual"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_bayar">Total bayar</label>
                                <input type="text" class="form-control uang" id="total_bayar" name="total_bayar"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>