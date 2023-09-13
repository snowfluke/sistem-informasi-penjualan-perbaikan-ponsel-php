<?php hakAkses(['admin']); $now = date('Y-m-d'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
                <marquee class="teks"> SELAMAT DATANG DI TERAPI PONSEL, SAHABAT SEHAT PONSEL! </marquee>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $_SESSION['username'] ?></h5>
            <p class="card-text">Data data yang telah di input silahkan dicek kembali dan jangan sampai ada yang tidak diinput ya</p>
        </div>
    </div>

</div>
<!-- /.container-fluid -->