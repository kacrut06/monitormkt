<?php
require('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $API = new RouterosAPI();

    if ($API->connect($router_ip, $router_user, $router_pass, $router_port)) {
        $API->comm("/ip/hotspot/user/add", [
            "name" => $_POST['username'],
            "password" => $_POST['password'],
            "profile" => $_POST['profile'],
            "server" => $_POST['server']
        ]);
        $API->disconnect();
        echo "User Hotspot berhasil ditambahkan!";
    } else {
        echo "Gagal terhubung ke router!";
    }
}
?>
