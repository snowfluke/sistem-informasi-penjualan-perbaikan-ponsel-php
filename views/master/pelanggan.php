<?php hakAkses(['admin']) ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('#pelangganModal .modal-title').html('Tambah pelanggan');
        $('[name="nama_pelanggan"]').val("").trigger('change');
        $('[name="alamat_pelanggan"]').val("").trigger('change');
        $('[name="no_hp_pelanggan"]').val("").trigger('change');
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#pelangganModal .modal-title').html('Edit pelanggan');
        $('[name="nama_pelanggan"]').val("").trigger('change');
        $('[name="alamat_pelanggan"]').val("").trigger('change');
        $('[name="no_hp_pelanggan"]').val("").trigger('change');
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_pelanggan.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id"]').val(data.id_pelanggan);
                $('[name="nama_pelanggan"]').val(data.nama_pelanggan);
                $('[name="no_hp_pelanggan"]').val(data.no_hp_pelanggan);
                $('[name="alamat_pelanggan"]').val(data.alamat_pelanggan);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pelanggan</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#pelangganModal"
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
                            <th>NO HP</th>
                            <th>ALAMAT</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM tb_pelanggan ORDER BY id_pelanggan DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama_pelanggan']; ?></td>
                            <td><?= $row['no_hp_pelanggan']; ?></td>
                            <td><?= $row['alamat_pelanggan']; ?></td>
                            <td>
                            <div class="d-inline-flex p-2">
                                <a href="#pelangganModal" data-toggle="modal" onclick="submit(<?=$row['id_pelanggan'];?>)"
                                    class="btn btn-sm btn-circle btn-info mr-2"><i class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>/process/process_pelanggan.php?act=<?=encrypt('delete');?>&id=<?=encrypt($row['id_pelanggan']);?>"
                                    class="btn btn-sm btn-circle btn-danger btn-hapus"><i class="fas fa-trash"></i></a>
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

<!-- Modal Tambah pelanggan -->
<div class="modal fade" id="pelangganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?=base_url();?>process/process_pelanggan.php" method="post">
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
                                <label>Nama pelanggan</label>
                                <input type="hidden" name="id" class="form-control">
                                <input type="text" class="form-control" name="nama_pelanggan" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="number" class="form-control" name="no_hp_pelanggan" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat_pelanggan" id="alamat_pelanggan" cols="30" rows="5" class="form-control" required></textarea>
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