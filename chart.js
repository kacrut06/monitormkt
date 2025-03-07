document.addEventListener("DOMContentLoaded", function () {
    var ctx1 = document.getElementById("cpuMemoryChart")?.getContext("2d");
    var ctx2 = document.getElementById("trafficChart")?.getContext("2d");

    if (ctx1 && ctx2) {
        var cpuUsage = document.getElementById("cpuMemoryChart").dataset.cpu;
        var memoryUsage = document.getElementById("cpuMemoryChart").dataset.memory;
        var rxTraffic = document.getElementById("trafficChart").dataset.rx;
        var txTraffic = document.getElementById("trafficChart").dataset.tx;

        // Grafik CPU & Memory
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["CPU", "Memory"],
                datasets: [
                    {
                        label: "Usage (%)",
                        data: [cpuUsage, memoryUsage],
                        backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)"],
                        borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)"],
                        borderWidth: 1,
                    },
                ],
            },
            options: { responsive: true },
        });

        // Grafik Traffic Interface
        new Chart(ctx2, {
            type: "bar",
            data: {
                labels: ["Ether1 Rx", "Ether1 Tx"],
                datasets: [
                    {
                        label: "Traffic (bps)",
                        data: [rxTraffic, txTraffic],
                        backgroundColor: ["rgba(255, 206, 86, 0.2)", "rgba(75, 192, 192, 0.2)"],
                        borderColor: ["rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)"],
                        borderWidth: 1,
                    },
                ],
            },
            options: { responsive: true },
        });
    }
});
