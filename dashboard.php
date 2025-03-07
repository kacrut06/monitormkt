<?php
session_start();
require('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Paksa login jika belum masuk
    exit();
}

$API = new RouterosAPI();
if (!$API->connect($router_ip, $router_user, $router_pass, $router_port)) {
    die("Gagal terhubung ke router! Pastikan IP, user, password, dan firewall sudah benar.");
} else {
    echo "Berhasil terhubung ke router!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Monitoring Mikrotik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard Monitoring Mikrotik</h2>
        <p>Selamat datang, <b><?php echo $_SESSION['username']; ?></b>!</p>
        <a href="tambah_user.php" class="btn btn-success">Tambah User Hotspot/PPPoE</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <h3 class="mt-4">Informasi Router</h3>
        <table class="table table-bordered">
            <tr><th>CPU Load</th><td><?php echo $systemInfo[0]['cpu-load']; ?>%</td></tr>
            <tr><th>Free Memory</th><td><?php echo $systemInfo[0]['free-memory']; ?> Bytes</td></tr>
            <tr><th>Uptime</th><td><?php echo $systemInfo[0]['uptime']; ?></td></tr>
        </table>
    </div>
</body>
</html>
