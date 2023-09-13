<?php hakAkses(['admin', 'kasir']); ?>
<script>
    function submit(x, id_kasir) {
        if (x == 'add') {
            $('#perbaikanModal .modal-title').html('Tambah perbaikan');
            $('[name="id_kerusakan"]').val("").trigger('change');
            $('[name="nama_pelanggan"]').val("").trigger('change');
            $('[name="tanggal"]').val("").trigger('change');
            $('[name="alamat"]').val("").trigger('change');
            $('[name="no_hp"]').val("").trigger('change');
            $('[name="merk_seri_hp"]').val("").trigger('change');
            $('[name="id_kasir"]').val(id_kasir);
            $('#ubah-perbaikan').hide();
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#perbaikanModal .modal-title').html('Edit perbaikan');
            $('[name="id_kerusakan"]').val("").trigger('change');
            $('[name="id_kasir"]').val('change');
            $('[name="tanggal"]').val("").trigger('change');
            $('[name="nama_pelanggan"]').val("").trigger('change');
            $('[name="alamat"]').val("").trigger('change');
            $('[name="no_hp"]').val("").trigger('change');
            $('[name="merk_seri_hp"]').val("").trigger('change');
            $('[name="tambah"]').hide();
            $('#ubah-perbaikan').show();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_perbaikan.php',
                dataType: 'json',
                success: function (data) {
                    $('[name="id"]').val(data.id_perbaikan);
                    $('[name="tanggal"]').val(data.tanggal);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="id_kasir"]').val(data.id_kasir);
                    $('[name="id_kerusakan"]').val(data.id_kerusakan);
                    $('[name="alamat"]').val(data.alamat);
                    $('[name="merk_seri_hp"]').val(data.merk_seri_hp);
                    $('[name="nama_pelanggan"]').val(data.nama_pelanggan);
                    $('[name="no_hp"]').val(data.no_hp);
                    $('[name="status_perbaikan"]').val(data.status_perbaikan);
                }
            });
        }
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reparasi / Perbaikan</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#perbaikanModal"
                onclick="submit('add', '<?= $_SESSION['id'] ?>')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
            <a href="<?= base_url(); ?>process/cetak_perbaikan_today.php" target="_blank"
                class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak reparasi hari ini</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5">NO</th>
                            <th>TANGGAL</th>
                            <th>MERK</th>
                            <th>KERUSAKAN</th>
                            <th>PEMILIK</th>
                            <th>ALAMAT</th>
                            <th>HP</th>
                            <th>BIAYA</th>
                            <th>STATUS</th>
                            <th>KASIR</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT x.*, x1.nama_kerusakan, x1.harga_perbaikan, x2.nama FROM tb_perbaikan x JOIN tb_jenis_kerusakan x1 ON x1.id_kerusakan = x.id_kerusakan JOIN tb_kasir x2 ON x2.id_kasir = x.id_kasir ORDER BY x.status_perbaikan ASC") or die(mysqli_error($con));
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
                                    <?= $row['merk_seri_hp']; ?>
                                </td>
                                <td>
                                    <?= $row['nama_kerusakan']; ?>
                                </td>
                                <td>
                                    <?= $row['nama_pelanggan']; ?>
                                </td>
                                <td>
                                    <?= $row['alamat']; ?>
                                </td>
                                <td>
                                    <?= $row['no_hp']; ?>
                                </td>
                                <td>
                                    <?= $row['harga_perbaikan']; ?>
                                </td>
                                <td>
                                    <?= $row['status_perbaikan']; ?>
                                </td>
                                <td>
                                    <?= $row['nama']; ?>
                                </td>
                                <td>

                                    <div class="d-inline-flex p-2">
                                        <a href="#perbaikanModal" data-toggle="modal"
                                            onclick="submit(<?= $row['id_perbaikan']; ?>)"
                                            class="btn btn-sm btn-circle btn-info mr-2"><i class="fas fa-edit"></i></a>
                                        <?php if ($row['status_perbaikan'] == 'belum'): ?>
                                            <a href="<?= base_url(); ?>/process/process_perbaikan.php?act=<?= encrypt('selesai'); ?>&id=<?= encrypt($row['id_perbaikan']); ?>"
                                                class="btn btn-sm btn-circle btn-success mr-2 selesai"><i
                                                    class="fas fa-check"></i></a>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['role'] == 'admin'): ?>

                                            <a href="<?= base_url(); ?>/process/process_perbaikan.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['id_perbaikan']); ?>"
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

<!-- Modal Tambah Perbaikan} -->
<div class="modal fade" id="perbaikanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/process_perbaikan.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Reparasi</h5>
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
                                <label for="id_kerusakan">Jenis kerusakan <span class="text-danger">*</span></label>
                                <select name="id_kerusakan" id="id_kerusakan" class="form-control" style="width:100%;"
                                    required>
                                    <option value="">-- Pilih jenis kerusakan --</option>
                                    <?= list_jenis_kerusakan(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merk_seri_hp">Merk seri HP<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="merk_seri_hp" name="merk_seri_hp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pelanggan">Nama Pelanggan<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">No HP<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                        </div>
                        <div id="ubah-perbaikan" class="col-md-6">
                            <div class="form-group">
                                <label for="status_perbaikan">Status perbaikan</label>
                                <select name="status_perbaikan" id="status_perbaikan" class="form-control"
                                    style="width:100%;">
                                    <option value='belum'>Belum</option>
                                    <option value='selesai'>Selesai</option>
                                </select>
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