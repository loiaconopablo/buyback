<page backtop="2mm" backbottom="5mm" backleft="5mm" backright="5mm" format="A4" orientation="landscape">
<page_footer>
	<table style="width:100%;">
		<tr><td><?php echo yii::t('app', 'Delivery confirmation in Point of Sale products sold BGH'); ?></td></tr>
		<tr>
			<td style="font-size:8pt;">
			<div style="display:inline; width:250px; height:100px; background-color:#CCC; padding: 5px; margin-right:10px;"><?php
            echo Yii::t('app', 'Seller s sign');
            ?></div>
			<div style="float:right; display:inline; width:250px; height:100px; background-color:#CCC; padding: 5px"><?php
            echo Yii::t('app', 'seal and signature of the seller'); 
            ?></div>
			</td>
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
                        echo Yii::t('app', 'receipt');
                    ?><br/><?php echo Yii::t('app', 'used goods to final consumers not registrable'); ?><br/><b><?php echo Yii::t('app', 'code'); ?> Nº 49, R.G. AFIP 3411</b></p>
					</td>
				</tr>
				<tr>
					<td style="width:50%; padding-top:15px;"><img id="logo" style="width:100px; display:inline; vertical-align:middle" src="<?php echo Yii::getPathOfAlias('webroot') . '/images/buyback_logo.png';?>"></td>
					<td style="width:50%; padding-top:15px; text-align:right;"><img id="logo-bgh" style="vertical-align:middle" src="<?php echo Yii::getPathOfAlias('webroot') . '/images/bgh_logo.png';?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
					<p style="font-size:8pt; line-height:10pt;"><b>BGH SA</b> &#8226; <b>CUIT:</b> 30-50361289-1 &#8226; <b>BRASIL 731</b> &#8226; CABA<br/><b>IIBB</b>: 901-918955-9 &#8226; <b><?php 
                        echo Yii::t('app', 'start date'); ?></b>: 01/02/1974 &#8226; <b><?php echo Yii::t('app', 'sell conditions'); ?></b>: <?php
                        echo Yii::t('app', 'cash'); ?></p>
					</td>
				</tr>
				</table>
				<table style="width:100%;">
				<tr>
					<td colspan=5><h3><?php echo Yii::t('app', 'Content of the sale'); ?></h3></td>
				</tr>
				<tr style="background-color:#CCC; padding: 5px 0;">
					<td style="width:20%">Marca</td>
					<td style="width:20%">Modelo</td>
					<td style="width:20%">Operador</td>
					<td style="width:20%">IMEI</td>
					<td style="width:20%"><?php echo Yii::t('app', 'Price'); ?></td>
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
				<tr><td colspan="4"><h3>Datos de la venta</h3></td></tr>
				<?php $date = new DateTime($model->created_at);?>
				<tr>
					<td style="width:7%; font-weight:bold;">CAI:</td>
					<td style="width:25%;"><?php echo $model->cae;?></td>
					<td style="width:19%; font-weight:bold;">Entregado en:</td>
					<td style="width:49%;"><?php echo $model->point_of_sale->address;?></td>
				</tr>
			</table>

			<table style="width:100%; border-bottom: 1px solid #CCC;">
				<tr style="background-color:#CCC; padding: 5px 0;">
					<td style="width:34%">Nro. de Comprobante</td>
					<td style="width:33%">Nro. productos entregados</td>
					<td style="width:33%">Fecha</td>
				</tr>
				<tr>
					<td><?php echo $model->contract_number;?></td>
					<td>1</td>
					<td><?php echo $date->format('d/m/Y');?></td>
				</tr>
			</table>
			<table style="width:100%; font-size:10pt; line-height:2pt; padding-top:12px;">
				<tr>
					<td style="width:26%; font-weight:bold;">Nombre y Apellidos:</td>
					<td style="width:53%;"><?php echo $model->seller->name;?></td>
					<td style="width:6%; font-weight:bold;">DNI:</td>
					<td style="width:15%;"><?php echo $model->seller->dni;?></td>
				</tr>
			</table>
			<table style="width:100%; margin:0px; padding:0px;">
				<tr>
					<td style="width:12%; font-weight:bold;">Telefono:</td>
					<td style="width:15%;"><?php echo $model->seller->phone;?></td>
					<td style="width:9%; font-weight:bold;"><?php echo Yii::t('app', 'E-mail');?>:</td>
					<td style="width:66%;"><?php echo $model->seller->mail;?></td>
				</tr>
			</table>
			<table style="width:100%; margin:0px; padding:0px; table-layout:fixed;">
				<tr><td colspan="4"></td></tr>
				<tr>
					<td colspan="4" style="width:12%; font-weight:bold;"><?php echo Yii::t('app', 'Dirección');?>:</td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $model->seller->province;?></td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $model->seller->locality;?></td>
				</tr>
				<tr>
					<td colspan="4" style="width:88%; font-size:9pt;"><?php echo $model->seller->address;?></td>
				</tr>
			</table>
			</td><!-- fin col 1 -->
			<td style="width:50%; vertical-align:top; padding-left:10px;"><!-- col 2 -->
				<?php $this->renderPartial('condiciones_pdf');?>
				<p><div style="text-align:right; font-size:8pt;"><i><?php echo $footer;?></i></div></p>
			</td><!-- fin col 2-->
		</tr>
	</table>
</page>
