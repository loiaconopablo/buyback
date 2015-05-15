<table class="table table-condensed">
	<thead>
	</thead>
	<tbody>
		<?php foreach ($model as $row_number => $row): ?>
		<tr>
			<td><b><?php echo $row_number ?></b></td>

    <?php foreach ($row as $key => $value): ?>
				<td>
        <?php echo $value; ?>
				</td>
    <?php 

endforeach;?>
		<tr>
    <?php 

endforeach; ?>
	</tbody>
</table>
