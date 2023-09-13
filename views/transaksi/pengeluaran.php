<?php hakAkses(['admin', 'kasir']); ?>
<script>
    function submit(x, id_kasir) {
        if (x == 'add') {
            $('#pengeluaranModal .modal-title').html('Tambah pengeluaran');
            $('[name="id_barang"]').val("").trigger('change');
            $('[name="tanggal"]').val("").trigger('change');
            $('[name="keperluan"]').val("").trigger('change');
            $('[name="tambah_stok"]').val("").trigger('change');
            $('[name="total_pengeluaran"]').val("").trigger('change');
            $('[name="bukti"]').val("").trigger('change');
            $('[name="deskripsi"]').val("").trigger('change');
            $('[name="id_kasir"]').val(id_kasir);
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        }


        function checkRestok() {
            let selectedOption = $('#keperluan').val()
            if (selectedOption != 'RESTOK') {
                $('.restok').addClass('d-none')
                $('.deskripsi-pengeluaran').removeClass('d-none')
                return;
            }

            $('.restok').removeClass('d-none');
            $('.deskripsi-pengeluaran').addClass('d-none')
        }

        $(document).ready(function () {
            $("#keperluan").on("change", checkRestok);
        })
    }

    function setBuktiModalImg(src) {
        $('#buktiModal-img').html(`<img class="img-fluid" src='${src}'/>`);
    }

</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengeluaran</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal"
                data-target="#pengeluaranModal" onclick="submit('add', '<?= $_SESSION['id'] ?>')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
            <a href="<?= base_url(); ?>process/cetak_pengeluaran_today.php" target="_blank"
                class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak pengeluaran hari ini</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5">NO</th>
                            <th>TANGGAL</th>
                            <th>KEPERLUAN</th>
                            <th>DESKRIPSI</th>
                            <th>PENGELUARAN</th>
                            <th>BUKTI</th>
                            <th>KASIR</th>
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <th>AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT * FROM tb_pengeluaran LEFT JOIN tb_kasir ON tb_pengeluaran.id_kasir = tb_kasir.id_kasir ORDER BY tb_pengeluaran.tanggal ASC") or die(mysqli_error($con));
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
                                    <?= $row['keperluan']; ?>
                                </td>
                                <td>
                                    <?= $row['deskripsi']; ?>
                                </td>
                                <td>
                                    <?= $row['total_pengeluaran']; ?>
                                </td>
                                <td>
                                    <a data-toggle="modal" href="#buktiModal"
                                        onclick="setBuktiModalImg('<?= base_url() . 'bukti/' . $row['bukti'] ?>')">Lihat
                                        bukti</a>
                                </td>
                                <td>
                                    <?= $row['nama']; ?>
                                </td>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                    <td>
                                        <div class="d-inline-flex p-2">
                                            <a href="<?= base_url(); ?>/process/process_pengeluaran.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['id_pengeluaran']); ?>"
                                                class="btn btn-sm btn-circle btn-danger btn-hapus"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah pengeluaran -->
<div class="modal fade" id="pengeluaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/process_pengeluaran.php" method="post"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah pengeluaran</h5>
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
                                <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                                <select name="keperluan" id="keperluan" class="form-control" style="width:100%;"
                                    required>
                                    <option value="">-- Pilih Keperluan --</option>
                                    <option value="RESTOK">Restok</option>
                                    <option value="SPAREPART">Sparepart</option>
                                    <option value="LOGISTIK">Logistik</option>
                                    <option value="AKOMODASI">Akomodasi</option>
                                    <option value="LAINNYA">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 restok d-none">
                            <div class="form-group">
                                <label for="id_barang">Nama Barang <span class="text-danger">*</span></label>
                                <select name="id_barang" id="id_barang" class="form-control" style="width:100%;">
                                    <option value="">-- Pilih Barang --</option>
                                    <?= list_barang(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 restok d-none">
                            <div class="form-group">
                                <label for="tambah_stok">Jumlah restok<span class="text-danger">*</span></label>
                                <input type="number" class="form-control uang" id="tambah_stok" name="tambah_stok">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_pengeluaran">Total pengeluaran<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="total_pengeluaran"
                                    name="total_pengeluaran">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bukti">Bukti<span class="text-danger">*</span></label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" class="form-control"
                                    id="bukti" name="bukti" required>
                            </div>
                        </div>
                        <div class="col-md-12 deskripsi-pengeluaran">
                            <div class="form-group">
                                <label>Deskripsi Pengeluaran<span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="3"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        Pastikan data yang diinputkan telah benar!
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lihat Gambar -->
<div class="modal fade" id="buktiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lihat bukti pengeluaran</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="buktiModal-img" class="col-md-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>