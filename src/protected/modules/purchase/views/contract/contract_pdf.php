<page backtop="2mm" backbottom="5mm" backleft="5mm" backright="5mm" format="A4" orientation="landscape">
<page_footer>
	<table style="width:100%;">
		<tr><td colspan="2"><?php echo yii::t('contract', 'Confirmación de la entrega en Punto de Venta de los productos vendidos a BGH'); ?></td></tr>
		<tr>
			<td style="font-size:8pt; width:50%">
			<div style="display:inline; width:250px; height:100px; background-color:#CCC; padding: 5px; margin-right:10px;"><?php
            echo Yii::t('contract', 'Firma del vendedor');
            ?></div>
			<div style="float:right; display:inline; width:250px; height:100px; background-color:#CCC; padding: 5px"><?php
            echo Yii::t('contract', 'Sello y Firma Punto de Venta'); 
            ?></div>
			</td>
			<td style="text-align: right; vertical-align: bottom; width:50%; font-size:8pt;"><?php echo $footer;?></td>
		</tr>
	</table>
</page_footer>
	<table style="width:100%;"><!-- wrap total -->
		<tr>
			<td style="width:50%; vertical-align:top;"><!-- col 1 -->
				<table style="width:100%; border-bottom:2px; border-color:#2e6da4;">
				<tr>
					<td colspan="2" style="text-align:center;">
					<p style="font-size:9pt; line-height:10pt;"><?php
                        echo Yii::t('contract', 'Comprobante de Compra');
                    ?><br/><?php echo Yii::t('contract', 'BIENES USADOS NO REGISTRABLES A CONSUMIDORES FINALES'); ?><br/><?php echo Yii::t('contract', 'CODIGO'); ?> Nº 49, R.G. AFIP 3411</p>
					</td>
				</tr>
				<tr>
					<td style="width:50%; padding-top:15px;"><img id="logo" style="width:100px; display:inline; vertical-align:middle" src="<?php echo Yii::getPathOfAlias('webroot') . '/images/buyback_logo.png';?>"></td>
					<td style="width:50%; padding-top:15px; text-align:right;"><img id="logo-bgh" style="vertical-align:middle" src="<?php echo Yii::getPathOfAlias('webroot') . '/images/bgh_logo.png';?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
					<p style="font-size:8pt; line-height:10pt;">BGH SA &#8226; CUIT: 30-50361289-1 &#8226; BRASIL 731 &#8226; CABA<br/>IIBB: 901-918955-9 &#8226; <?php 
                        echo Yii::t('contract', 'INICIO DE ACTIVIDADES'); ?>: 01/02/1974 &#8226; <?php echo Yii::t('contract', 'CONDICION DE VENTA'); ?>: <?php
                        echo Yii::t('contract', 'CONTADO'); ?></p>
					</td>
				</tr>
				</table>

				<table style="width:100%;">
				<tr>
					<td colspan=5><span style="font-size: 14pt"><?php echo Yii::t('contract', 'Contenido de la venta'); ?></span></td>
				</tr>
				<tr style="background-color:#CCC; padding: 5px 0;">
					<td style="width:20%"><?php echo Yii::t('app', 'Marca'); ?></td>
					<td style="width:20%"><?php echo Yii::t('app', 'Modelo'); ?></td>
					<td style="width:20%"><?php echo Yii::t('app', 'Operador'); ?></td>
					<td style="width:20%"><?php echo Yii::t('app', 'IMEI'); ?></td>
					<td style="width:20%"><?php echo Yii::t('app', 'Precio'); ?></td>
				</tr>
				<tr>
					<td><?php echo $model->brand;?></td>
					<td><?php echo $model->model;?></td>
					<td><?php echo $model->carrier_name;?></td>
					<td><?php echo $model->imei;?></td>
					<td align="right">$ <?php echo $model->purchase_price;?></td>
				</tr>
			</table>

			<table style="width:100%;">
				<tr><td colspan="4"><span style="font-size:14pt"><?php echo Yii::t('app', 'Datos de la venta'); ?></span></td></tr>
				<?php $date = new DateTime($model->created_at);?>
				<tr>
					<td style="width:7%;">CAI:</td>
					<td style="width:25%;"><?php echo $model->cae;?></td>
					<td style="width:19%;"><?php echo Yii::t('app', 'Entregado en'); ?>:</td>
					<td style="width:49%;"><?php echo $model->point_of_sale->address;?></td>
				</tr>
			</table>

			<table style="width:100%; border-bottom: 1px solid #CCC;">
				<tr style="background-color:#CCC; padding: 5px 0;">
					<td style="width:34%"><?php echo Yii::t('app', 'Nº de Comprobante'); ?></td>
					<td style="width:33%"><?php echo Yii::t('app', 'Productos entregados'); ?></td>
					<td style="width:33%"><?php echo Yii::t('app', 'Fecha'); ?></td>
				</tr>
				<tr>
					<td><?php echo $model->contract_number;?></td>
					<td>1</td>
					<td><?php echo $date->format('d/m/Y');?></td>
				</tr>
			</table>
			<table style="width:100%; font-size:10pt; line-height:2pt; padding-top:12px;">
				<tr>
					<td style="width:26%;"><?php echo Yii::t('app', 'Apellido y Nombre'); ?>:</td>
					<td style="width:53%;"><?php echo $seller['name'];?></td>
					<td style="width:6%;"><?php echo Yii::t('app', 'DNI'); ?>:</td>
					<td style="width:15%;"><?php echo $seller['identification'];?></td>
				</tr>
			</table>
			<table style="width:100%; margin:0px; padding:0px;">
				<tr>
					<td style="width:12%;"><?php echo Yii::t('app', 'Teléfono'); ?>:</td>
					<td style="width:15%;"><?php echo $seller['phone'];?></td>
					<td style="width:9%;"><?php echo Yii::t('app', 'Mail');?>:</td>
					<td style="width:66%;"><?php echo $seller['mail'];?></td>
				</tr>
			</table>
			<table style="width:100%; margin:0px; padding:0px; table-layout:fixed;">
				<tr><td colspan="4"></td></tr>
				<tr>
					<td colspan="4" style="width:12%;"><?php echo Yii::t('app', 'Dirección');?>:</td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $seller['province'];?></td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $seller['locality'];?></td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $seller['address'];?></td>
				</tr>
			</table>
			</td><!-- fin col 1 -->
			<td style="width:50%; vertical-align:top; padding-left:10px;"><!-- col 2 -->
				<?php $this->renderPartial('condiciones_pdf');?>
				
			</td><!-- fin col 2-->
		</tr>
	</table>
</page>