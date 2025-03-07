<?php
require('routeros_api.class.php');

$API = new RouterosAPI();

$router_ip = '103.157.24.28:1200';
$router_user = 'songgleng';
$router_pass = 'sahabat123';
$router_port = '8728';

if ($API->connect($router_ip, $router_user, $router_pass, $router_port)) {
    $systemInfo = $API->comm("/system/resource/print");
    $interfaces = $API->comm("/interface/monitor-traffic", [
        "interface" => "ether1",
        "once" => ""
    ]);
    $API->disconnect();
} else {
    die("<div class='alert alert-danger text-center mt-4'>Gagal terhubung ke router!</div>");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Mikrotik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="js/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard Monitoring Mikrotik</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Informasi Router</h4>
                <table class="table table-bordered">
                    <tr><th>CPU Load</th><td><?php echo $systemInfo[0]['cpu-load']; ?>%</td></tr>
                    <tr><th>Free Memory</th><td><?php echo $systemInfo[0]['free-memory']; ?> Bytes</td></tr>
                    <tr><th>Uptime</th><td><?php echo $systemInfo[0]['uptime']; ?></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h4>Grafik CPU & Memory</h4>
                <canvas id="cpuMemoryChart"
                    data-cpu="<?php echo $systemInfo[0]['cpu-load']; ?>"
                    data-memory="<?php echo round(($systemInfo[0]['free-memory'] / $systemInfo[0]['total-memory']) * 100, 2); ?>">
                </canvas>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Grafik Traffic Interface</h4>
                <canvas id="trafficChart"
                    data-rx="<?php echo $interfaces[0]['rx-bits-per-second']; ?>"
                    data-tx="<?php echo $interfaces[0]['tx-bits-per-second']; ?>">
                </canvas>
            </div>
        </div>
    </div>
</body>
</html>
