<!DOCTYPE html>
<html>

<head>
	<title>NOCKANDA EXAMPLE</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
	<script type="text/javascript" charset="utf-8"
		src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
	<link href="index_style.css" rel="stylesheet">
</head>

<body>
	<div style="box-shadow: 5px 5px 30px gray; border-radius: 30px; height: 400px; width: 650px;">
		<br>
		<h2 style="margin-left: 20px;">User Stat</h2>
	<div style="width:600px; margin-left: 20px;">
		<canvas id="line1"></canvas>
	</div>
	</div>
	<script>
		var ctx = document.getElementById('line1').getContext('2d');
		var chart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($mydate); ?>,
				datasets: [
					{
						label: 'Temperature',
						backgroundColor: 'transparent',
						borderColor: "#13ED00",
						data: <?php echo json_encode($mytemp); ?>
					},
					{
						label: 'humidity',
						backgroundColor: 'transparent',
						borderColor: "#FC6BFF",
						data: <?php echo json_encode($myhumi); ?>
					}
				],

			},
			options: {}
		});
	</script>
</body>

</html>