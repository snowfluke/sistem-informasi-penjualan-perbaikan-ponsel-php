<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">Terapi Ponsel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Beranda -->
    <li class="nav-item <?= isset($home) ? 'active' : ''; ?>">
        <a class="nav-link" href="?#">
            <i class="fas fa-fw fa-home"></i>
            <span>Dasbor</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>
    <?php if (isset($_SESSION['role'])): ?>
        <!-- Nav Item - Pages Collapse Menu -->

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <li class="nav-item <?= isset($master) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master" aria-expanded="true"
                    aria-controls="master">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Master</span>
                </a>
                <div id="master" class="collapse <?= isset($master) ? 'show' : ''; ?>" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= isset($kasir) ? 'active' : ''; ?>" href="?kasir">Kasir</a>
                        <a class="collapse-item <?= isset($barang) ? 'active' : ''; ?>" href="?barang">Barang</a>
                        <a class="collapse-item <?= isset($jenis_kerusakan) ? 'active' : ''; ?>" href="?jenis_kerusakan">Jenis
                            Kerusakan</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'kasir'): ?>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= isset($transaksi) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true"
                    aria-controls="transaksi">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Transaksi</span>
                </a>
                <div id="transaksi" class="collapse <?= isset($transaksi) ? 'show' : ''; ?>" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= isset($penjualan) ? 'active' : ''; ?>" href="?penjualan">Penjualan</a>
                        <a class="collapse-item <?= isset($perbaikan) ? 'active' : ''; ?>" href="?perbaikan">Reparasi</a>
                        <a class="collapse-item <?= isset($pengeluaran) ? 'active' : ''; ?>" href="?pengeluaran">Pengeluaran</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= isset($laporan) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true"
                    aria-controls="laporan">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Laporan</span>
                </a>
                <div id="laporan" class="collapse <?= isset($laporan) ? 'show' : ''; ?>" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= isset($lap_penjualan) ? 'active' : ''; ?>" href="?lap_penjualan">
                            Laporan Penjualan</a>
                        <a class="collapse-item <?= isset($lap_perbaikan) ? 'active' : ''; ?>" href="?lap_perbaikan">
                            Laporan Reparasi</a>
                        <a class="collapse-item <?= isset($lap_pengeluaran) ? 'active' : ''; ?>" href="?lap_pengeluaran">
                            Laporan Pengeluaran</a>
                        <a class="collapse-item <?= isset($lap_keuntungan) ? 'active' : ''; ?>" href="?lap_keuntungan">
                            Laporan Keuntungan</a>
                        <a class="collapse-item <?= isset($lap_stok) ? 'active' : ''; ?>" href="?lap_stok">
                            Laporan Stok</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->