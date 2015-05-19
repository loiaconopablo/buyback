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
        <?php echo GxHtml::encode($data->getAttributeLabel('point_of_sale_id')); ?>:
				</b>
			</td>
			<td>
								<?php echo GxHtml::encode(GxHtml::valueEx($data->point_of_sale)); ?>
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
		</tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('username')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->username); ?>
					</td>
		</tr>	
				
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('mail')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->mail); ?>
					</td>
		</tr>	
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('employee_identification')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->employee_identification); ?>
					</td>
		</tr>	
			
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
        <?php echo GxHtml::encode($data->getAttributeLabel('last_login')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->last_login); ?>
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
				<tr>
			<td>
				<b>
        <?php echo GxHtml::encode($data->getAttributeLabel('is_password_validated')); ?>:
				</b>
			</td>
			<td>
        <?php echo GxHtml::encode($data->is_password_validated); ?>
					</td>
		<tr>	
					
	</tbody>
	</table>

</div>