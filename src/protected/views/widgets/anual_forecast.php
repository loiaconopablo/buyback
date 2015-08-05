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