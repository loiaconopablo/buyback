<div class="well">
	<table class="table">
		<col width="100">
		<tbody>
		<tr class="info">
			<td><b><?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:</b></td>
			<td><?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
</td>
		</tr>
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->name); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->created_at); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('updated_at')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->updated_at); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('user_update_id')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->user_update_id); ?>
					</td>
		<tr>	
					</tbody>
	</table>

</div>