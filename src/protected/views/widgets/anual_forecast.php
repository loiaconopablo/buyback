<table class="table table-bordered table-striped">
	<thead>
		<th><strong><?php echo Yii::t('app', 'Mes'); ?></strong></th>
		<?php foreach(DateHelper::getMonths() as $mes): ?>
			<th><?php echo $mes['month_name']; ?></th>
		<?php endforeach; ?>
	</thead>
	<body>
		<tr>
			<td><strong><?php echo Yii::t('app', 'Forecast'); ?></strong></td>
			<?php foreach($view_data['forecasts'] as $forecast): ?>
				<td><?php echo $forecast; ?></td>
			<?php endforeach; ?>
		<tr>
		<tr>
			<td><strong><?php echo Yii::t('app', 'Actual'); ?></strong></td>
			<?php foreach($view_data['compras'] as $compra): ?>
				<td><?php echo $compra; ?></td>
			<?php endforeach; ?>
		<tr>
	</body>
</table>
<script type="text/javascript">
	google.setOnLoadCallback(drawStuff);

  function drawStuff() {
    var data = new google.visualization.arrayToDataTable([
      ['Mes', 'Actual', 'Forecast'],
      <?php foreach(DateHelper::getMonths() as $mes): ?>
      	['<?php echo $mes["month_name"] ?>', <?php echo $view_data['compras'][$mes["month_number"]] ?>, <?php echo $view_data['forecasts'][$mes["month_number"]] ?>],
      <?php endforeach; ?>
    ]);

    var options = {
      //width: 900,
      chart: {
        title: 'Forecast / Actual',
        subtitle: 'Compración del Forecast contra las compras reales'
      },
      series: {
        0: { axis: 'Actual' }, // Bind series 0 to an axis named 'distance'.
        1: { axis: 'Forecast' } // Bind series 1 to an axis named 'brightness'.
      },

    };

  var chart = new google.charts.Bar(document.getElementById('anualforecast-chart'));
  chart.draw(data, options);
};
</script>

<div id="anualforecast-chart" style="width: 100%;"></div>