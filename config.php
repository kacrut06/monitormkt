<?php
session_start();
require('routeros_api.class.php');

// Konfigurasi Database
$host = "localhost";
$dbname = "monitor_mikrotik";
$username = "root"; // Sesuaikan dengan database Anda
$password = "";

// Koneksi ke Database
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Konfigurasi Router Mikrotik
$router_ip = '103.157.24.28:1200'; // Ganti dengan IP Mikrotik Anda
$router_user = 'songgleng';
$router_pass = 'sahabat123';
$router_port = '8728'; // Port API default

?>
