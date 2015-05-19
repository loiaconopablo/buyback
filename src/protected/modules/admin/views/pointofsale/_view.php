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
        <?php echo GxHtml::encode($data->getAttributeLabel('company_id')); ?>:
				</b>
			</td>
			<td>
								<?php echo GxHtml::encode(GxHtml::valueEx($data->company)); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('is_headquarter')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->is_headquarter); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('headquarter_id')); ?>:
				</b>
			</td>
			<td>
								<?php echo GxHtml::encode(GxHtml::valueEx($data->headquarter)); ?>
					</td>
		<tr>	
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
        <?php echo GxHtml::encode($data->getAttributeLabel('address')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->address); ?>
					</td>
		<tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('province')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->province); ?>
					</td>
		<tr>	
    <?php /*
    <tr>
    <td>
				<b>
					<?php echo GxHtml::encode($data->getAttributeLabel('locality')); ?>:
				</b>
    </td>
    <td>
					<?php echo GxHtml::encode($data->locality); ?>
					</td>
    <tr>	
				<tr>
    <td>
				<b>
					<?php echo GxHtml::encode($data->getAttributeLabel('phone')); ?>:
				</b>
    </td>
    <td>
					<?php echo GxHtml::encode($data->phone); ?>
					</td>
    <tr>	
				<tr>
    <td>
				<b>
					<?php echo GxHtml::encode($data->getAttributeLabel('mail')); ?>:
				</b>
    </td>
    <td>
					<?php echo GxHtml::encode($data->mail); ?>
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
					*/ ?>
	</tbody>
	</table>

</div>