<?php

    $data = getWeekData("visites", $G_USER->getId(), $G_PDO);
    $data_labels = $data["labels"];
    $data_visits = $data["data"];
    $data = getWeekData("likes", $G_USER->getId(), $G_PDO);
    $data_meows = $data["data"];

?>

    <div class="container-fluid user-card">
	<div class="panel panel-default">
		<div class="panel-heading">Statistiques</div>
		<div class="panel-body">
			<canvas id="stats" width="100%" height="400px"></canvas>
		</div>
	</div>
</div>

<script type="text/javascript">
	var ctx = document.getElementById("stats");
	var data = {
    	labels: <?php echo json_encode($data_labels) ?>,
    	datasets: [
        {
            label: "Visites",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(51,122,183,0.4)",
            borderColor: "rgba(51,122,183,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(51,122,183,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(51,122,183,1)",
            pointHoverBorderColor: "rgba(51,122,183,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo json_encode($data_visits) ?>,
            spanGaps: false,
        },
        {
            label: "Meows",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(217,83,79,0.4)",
            borderColor: "rgba(217,83,79,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(217,83,79,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(217,83,79,1)",
            pointHoverBorderColor: "rgba(217,83,79,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo json_encode($data_meows) ?>,
            spanGaps: false,
        }
    ]
};
	var chartInstance = new Chart(ctx, {
	    type: 'line',
	    data: data,
	    options: {
	        responsive: true,
	        maintainAspectRatio: false
	    }
	});
</script>