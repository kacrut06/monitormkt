<?php
require('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $API = new RouterosAPI();

    if ($API->connect($router_ip, $router_user, $router_pass, $router_port)) {
        $API->comm("/ppp/secret/add", [
            "name" => $_POST['username'],
            "password" => $_POST['password'],
            "service" => "pppoe",
            "profile" => $_POST['profile']
        ]);
        $API->disconnect();
        echo "User PPPoE berhasil ditambahkan!";
    } else {
        echo "Gagal terhubung ke router!";
    }
}
?>
