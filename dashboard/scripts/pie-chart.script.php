<script>
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
        labels: ["Insertion", "Modification", "Suppression"],
        datasets: [{
            data: [<?= htmlspecialchars($pie['nb_insertion']) ?>, <?= htmlspecialchars($pie['nb_modification']) ?>, <?= htmlspecialchars($pie['nb_suppression']) ?>],
            backgroundColor: ["#4e73df", "#1cc88a", "#D04848"],
            hoverBackgroundColor: ["#2e59d9", "#17a673", "#e74a3b"],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }, ],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false,
        },
        cutoutPercentage: 80,
    },
});
</script>