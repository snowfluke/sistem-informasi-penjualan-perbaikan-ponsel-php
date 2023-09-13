<?php hakAkses(['admin']) ?>
<script>
    function submit(x) {
        if (x == 'add') {
            $('#barangModal .modal-title').html('Tambah barang');
            $('[name="nama_barang"]').val("").trigger('change');
            $('[name="deskripsi_barang"]').val("").trigger('change');
            $('[name="harga_barang"]').val("").trigger('change');
            $('[name="stok_barang"]').val("").trigger('change');
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#barangModal .modal-title').html('Edit barang');
            $('[name="nama_barang"]').val("").trigger('change');
            $('[name="deskripsi_barang"]').val("").trigger('change');
            $('[name="harga_barang"]').val("").trigger('change');
            $('[name="stok_barang"]').val("").trigger('change');
            $('[name="tambah"]').hide();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_barang.php',
                dataType: 'json',
                success: function (data) {
                    $('[name="id"]').val(data.id_barang);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="harga_barang"]').val(data.harga_barang);
                    $('[name="stok_barang"]').val(data.stok_barang);
                    $('[name="deskripsi_barang"]').val(data.deskripsi_barang);
                }
            });
        }
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#barangModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>NAMA</th>
                            <th>DESKRIPSI</th>
                            <th>HARGA</th>
                            <th>STOK</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT tb_barang.* FROM tb_barang ORDER BY tb_barang.id_barang DESC") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($query)):
                            ?>
                            <tr>
                                <td>
                                    <?= $n++; ?>
                                </td>
                                <td>
                                    <?= $row['nama_barang']; ?>
                                </td>
                                <td>
                                    <?= $row['deskripsi_barang']; ?>
                                </td>
                                <td>
                                    <?= $row['harga_barang']; ?>
                                </td>
                                <td>
                                    <?= $row['stok_barang']; ?>
                                </td>
                                <td>
                                    <div class="d-inline-flex p-2">
                                        <a href="#barangModal" data-toggle="modal"
                                            onclick="submit(<?= $row['id_barang']; ?>)"
                                            class="btn btn-sm btn-circle btn-info mr-2"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url(); ?>/process/process_barang.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['id_barang']); ?>"
                                            class="btn btn-sm btn-circle btn-danger btn-hapus"><i
                                                class="fas fa-trash"></i></a>
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

<!-- Modal Tambah Barang -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/process_barang.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="hidden" name="id" class="form-control">
                                <input type="text" class="form-control" name="nama_barang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="harga_barang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" class="form-control" name="stok_barang" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi Barang</label>
                                <textarea name="deskripsi_barang" id="deskripsi_barang" cols="30" rows="5"
                                    class="form-control" required></textarea>
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