<?php
function session_timeout()
{
    //lama waktu 30 menit = 1800
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();
        session_destroy();
        include 'conn.php';
        header("Location:" . $base_url . "login.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}
function delMask($str)
{
    return (int) implode('', explode('.', $str));
}
function hakAkses(array $a)
{
    $akses = $_SESSION['role'];
    if (!in_array($akses, $a)) {
        // header('Location:?');
        echo '<script>window.location = "?#";</script>';
    }
}
function bulan($bln)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    return $bulan[$bln];
}
function tahun()
{
    return [
        '2020',
        '2021',
        '2022',
        '2023',
        '2024',
        '2025'
    ];
}

function list_barang()
{
    include('conn.php');
    $query = mysqli_query($con, "SELECT * FROM tb_barang ORDER BY nama_barang ASC");
    $opt   = "";
    while ($row = mysqli_fetch_array($query)) {
        $opt .= "<option data-harga-barang=\"" . $row['harga_barang'] . "\" value=\"" . $row['id_barang'] . "\">" . $row['nama_barang'] . " (Rp. " . $row['harga_barang'] . ") | sisa: " . $row['stok_barang'] . "</option>";
    }
    return $opt;
}

function list_kasir()
{
    include('conn.php');
    $query = mysqli_query($con, "SELECT * FROM tb_kasir ORDER BY id_kasir ASC");
    $opt   = "";
    while ($row = mysqli_fetch_array($query)) {
        $opt .= "<option value=\"" . $row['id_kasir'] . "\">" . $row['nama'] . "</option>";
    }
    return $opt;
}

function list_jenis_kerusakan()
{
    include('conn.php');
    $query = mysqli_query($con, "SELECT * FROM tb_jenis_kerusakan ORDER BY harga_perbaikan ASC");
    $opt   = "";
    while ($row = mysqli_fetch_array($query)) {
        $opt .= "<option data-harga-perbaikan=\"" . $row['harga_perbaikan'] . "\" value=\"" . $row['id_kerusakan'] . "\">" . $row['nama_kerusakan'] . " | (Rp. " . $row['harga_perbaikan'] . ")</option>";
    }
    return $opt;
}

function encrypt($str)
{
    return base64_encode($str);
}
function decrypt($str)
{
    return base64_decode($str);
}

function base_url()
{
    $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $base_url .= "://" . $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    return $base_url;
}
function generateUniqueCode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code       = '';

    // Add current timestamp (UNIX timestamp) to the code
    $timestamp = time();
    $code .= strtoupper(base_convert($timestamp, 10, 36)); // Convert timestamp to base36

    // Generate the remaining characters
    $remainingLength = 4 - strlen($code);
    for ($i = 0; $i < $remainingLength; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}
?>