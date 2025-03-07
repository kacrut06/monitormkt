<?php
session_start();
require('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$API = new RouterosAPI();
$hotspotProfiles = [];
$pppoeProfiles = [];

if ($API->connect($router_ip, $router_user, $router_pass, $router_port)) {
    // Ambil daftar profile Hotspot
    $hotspotProfiles = $API->comm("/ip/hotspot/user/profile/print");

    // Ambil daftar profile PPPoE
    $pppoeProfiles = $API->comm("/ppp/profile/print");

    $API->disconnect();
} else {
    die("Gagal terhubung ke router!");
}

// Jika Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $service = $_POST['service'];
    $profile = $_POST['profile'];

    if ($API->connect($router_ip, $router_user, $router_pass, $router_port)) {
        if ($service == "hotspot") {
            $API->comm("/ip/hotspot/user/add", [
                "name" => $username,
                "password" => $password,
                "profile" => $profile
            ]);
        } else {
            $API->comm("/ppp/secret/add", [
                "name" => $username,
                "password" => $password,
                "service" => "pppoe",
                "profile" => $profile
            ]);
        }

        echo "<p class='text-success'>User $username berhasil ditambahkan dengan profile $profile!</p>";
        $API->disconnect();
    } else {
        die("Gagal terhubung ke router!");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User - Monitoring Mikrotik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function updateProfileList() {
            var service = document.getElementById("service").value;
            document.getElementById("hotspot_profiles").style.display = (service === "hotspot") ? "block" : "none";
            document.getElementById("pppoe_profiles").style.display = (service === "pppoe") ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah User Hotspot/PPPoE</h2>
        <form method="POST">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <label for="service">Pilih Layanan:</label>
            <select name="service" id="service" class="form-control mb-2" onchange="updateProfileList()">
                <option value="hotspot">Hotspot</option>
                <option value="pppoe">PPPoE</option>
            </select>

            <div id="hotspot_profiles">
                <label for="profile">Pilih Profile Hotspot:</label>
                <select name="profile" class="form-control mb-2">
                    <?php foreach ($hotspotProfiles as $profile) { ?>
                        <option value="<?= $profile['name']; ?>"><?= $profile['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="pppoe_profiles" style="display:none;">
                <label for="profile">Pilih Profile PPPoE:</label>
                <select name="profile" class="form-control mb-2">
                    <?php foreach ($pppoeProfiles as $profile) { ?>
                        <option value="<?= $profile['name']; ?>"><?= $profile['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Tambah User</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <script>
        updateProfileList(); // Jalankan saat pertama kali halaman dibuka
    </script>
</body>
</html>
