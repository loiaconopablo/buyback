<?php Yii::import('application.vendors.wsfe.*', true);?>
<?php $date = new DateTime($dispatch_note->created_at);?>

<page backtop="2mm" backbottom="5mm" backleft="5mm" backright="5mm" format="A4" orientation="portrait">
	<page_header><div style="font-size:8pt; font-style:italic;"><?php echo $footer;?></div></page_header>
	<page_footer>
		<table style="width:100%; font-family: arial, sans-serif; padding:0px 0px 10px 0px;">
			<tr>
				<td style="width:45%;"><div style="font-size:8pt; font-style:italic;"><?php echo $footer;?></div></td>
				<td style="width:26%; border-top:1px dotted #CCC;"><p style="font-size:8px;">FIRMA</p></td>
				<td style="width:3%;"></td>
				<td style="width:26%; border-top:1px dotted #CCC;"><p style="font-size:8px;">ACLARACION</p></td>
			</tr>
		</table>

	</page_footer>

	<table style="width:100%; font-family: arial, sans-serif; border-bottom:1px solid #CCC; padding-bottom:5px;">
			<tr><td colspan="4" style="padding-top:0px; margin-top:0px;"><p style="font-size:20px; font-weight:bold; text-align:center;">X</p></td></tr>
			<tr>
				<td colspan="4" style="padding-bottom:20px;"><p style="font-size:10px; text-align:center;">DOCUMENTO NO V&Aacute;LIDO COMO FACTURA<br/>C&Oacute;DIGO N&deg; 91</p></td>
			</tr>
			<tr>
				<td style="width:13%; text-align:left;"><img id="logo-bgh" style="vertical-align:middle" src="<?php echo Yii::getPathOfAlias('webroot') . '/images/bgh_logo.png';?>"></td>
				<td style="width:30%;">
					<p style="font-size:10px; line-height:120%;">
						<b>PIEDRAS 1450</b> CP: 1154 - CABA<br/>
						Tel: (5411) 43092027 - Fax: (5411) 4307660<br/>
						IVA RESPONSABLE INSCRIPTO
					</p>
				</td>
				<td style="width:25%;">
					<p style="font-size:10px;">
						CUIT: 30-50361289-1<br/>
						INGRESOS BRUTOS: 901-918955-9<br/>
						INICIO DE ACTIVIDADES: 01/07/01
					</p>
				</td>
				<td style="width:32%; text-align:right; font-size:12px; padding-bottom:5px;">
					<p>
					NOTA DE ENVIO N&deg; <?php echo str_pad($dispatch_note->dispatch_note_number, 8, "0", STR_PAD_LEFT);?>
					<br/><?php echo $date->format('d/m/Y');?>
					</p>
				</td>
			</tr>
		</table>

<table style="width:100%; font-family: arial, sans-serif; border-bottom:1px solid #CCC; padding:5px 0px 5px 0px;">
	<tr>
		<td colspan="4"><b>Origen</b></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Empresa Origen:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->company->name;?></td>
		<td style="text-align:right; font-size:11px;">N&deg; de Empresa:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->company->company_code;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">CUIT:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->company->cuit;?></td>
		<td style="text-align:right; font-size:11px;">Tel&eacute;fono:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->phone;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Domicilio:</td>
		<td style="font-weight:bold;" colspan="3"><?php echo $from->address;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Provincia:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->province;?></td>
		<td style="text-align:right; font-size:11px;">Localidad:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $from->locality;?></td>
	</tr>
</table>

<table style="width:100%; font-family: arial, sans-serif; border-bottom:1px solid #CCC; padding:5px 0px 5px 0px;">
	<tr>
		<td colspan="4"><b>Destinatario</b></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Señor/es:</td>
		<td style="width:37%; font-weight:bold;"><?php echo $to->name;?></td>
		<td style="text-align:right; font-size:11px;">N&deg; de Empresa:</td>
		<td style="width:37%; font-weight:bold;"><?php echo $to->company->company_code;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">CUIT:</td>
		<td style="width:37%; font-weight:bold;"><?php echo $to->company->cuit;?></td>
		<td style="text-align:right; font-size:11px;">Tel&eacute;fono:</td>
		<td style="font-weight:bold; width:37%;"><?php echo $to->phone;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Domicilio:</td>
		<td style="font-weight:bold;" colspane="3"><?php echo $to->address;?></td>

	</tr>
	<tr>
		<td style="text-align:right; font-size:11px;">Provincia:</td>
		<td style="width:37%; font-weight:bold;"><?php echo $to->province;?></td>
		<td style="text-align:right; font-size:11px;">Localidad:</td>
		<td style="width:37%; font-weight:bold;"><?php echo $to->locality;?></td>
	</tr>
</table>

<table style="width:100%; font-family: arial, sans-serif; border-bottom:3px double #CCC; padding:5px 0px 10px 0px;">
	<tr style="font-size:10px; font-weight:bold; border-bottom:1px solid #CCC;">
		<th style="width:10%; height:2%;">Nº Contrato</th>
		<th style="width:30%; height:2%;">Marca</th>
		<th style="width:30%; height:2%;">Modelo</th>
		<th style="width:15%; height:2%;">IMEI</th>
		<th style="width:15%; height:2%;">Vendedor</th>
	</tr>
	<?php foreach ($purchases as $purchase): ?>
		<?php
$contract_pdv_num = str_pad(WsfeClient::PUNTO_DE_VENTA, 4, "0", STR_PAD_LEFT);
$contract_cn_num = str_pad($purchase->contract_number, 8, "0", STR_PAD_LEFT);
$final_contract_number = $contract_pdv_num . '-' . $contract_cn_num;
?>
	<	<tr>
			<td><?php echo $final_contract_number;?></td>
			<td><?php echo $purchase->brand;?></td>
			<td><?php echo $purchase->model;?></td>
			<td><?php echo $purchase->imei;?></td>
			<td><?php echo $purchase->user;?></td>
		</tr>
	<?php endforeach;?>
</table>
	<?php if (strlen(trim($dispatch_note->comment))): ?>
		<?php echo $dispatch_note->comment;?>
	<?php endif;?>
</page>