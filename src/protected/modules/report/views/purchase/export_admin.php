<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'purchase-form',
    'enableAjaxValidation' => false,
    )
);
?>

<?php
    $attribute_options = array(
        'contract_number' => Yii::t('app', 'Nº Contrato'),
        'cae' => Yii::t('app', 'C.A.E.'),
        'imei' => Yii::t('app', 'IMEI'),
        'brand' => Yii::t('app', 'Marca'),
        'model' => Yii::t('app', 'Modelo'),
        'carrier' => Yii::t('app', 'Operador'),
        'purchase_price' => Yii::t('app', 'Precio de compra'),
        'created_at' => Yii::t('app', 'Fecha de creación'),
        'user_ip' => Yii::t('app', 'IP'),
        'comprobante_tipo' => Yii::t('app', 'Tipo de comprobante'),
        'associate_purchase' => Yii::t('app', 'Contrato asociado'),
        'status' => Yii::t('app', 'Estado'),
    );

    $attribute_point_of_sale_options = array(
        'name' => Yii::t('app', 'Nombre'),
        'address' => Yii::t('app', 'Dirección'),
        'province' => Yii::t('app', 'Provincia'),
        'locality' => Yii::t('app', 'Localidad'),
        'phone' => Yii::t('app', 'Teléfono'),
        'mail' => Yii::t('app', 'Mail'),
    );
    
    $attribute_company_options = array(
        'company_code' => Yii::t('app', 'Código'),
        'name' => Yii::t('app', 'Nombre'),
        'social_reason' => Yii::t('app', 'Razón social'),
        'cuit' => Yii::t('app', 'C.U.I.T.'),
        'address' => Yii::t('app', 'Dirección'),
        'province' => Yii::t('app', 'Provincia'),
        'locality' => Yii::t('app', 'Localidad'),
        'phone' => Yii::t('app', 'Teléfono'),
        'mail' => Yii::t('app', 'Mail'),
        'reference_name' => Yii::t('app', 'Referido'),
        'reference_phone' => Yii::t('app', 'Teléfono referencia'),
        'reference_mail' => Yii::t('app', 'Mail referencia'),

    );

    $attribute_user_options = array(
        'username' => Yii::t('app', 'Nombre'),
        'mail' => Yii::t('app', 'Mail'),
    );

    $attribute_seller_options = array(
        'name' => Yii::t('app', 'Nombre'),
        'dni' => Yii::t('app', 'D.N.I.'),
        'address' => Yii::t('app', 'Dirección'),
        'province' => Yii::t('app', 'Provincia'),
        'locality' => Yii::t('app', 'Localidad'),
        'phone' => Yii::t('app', 'Teléfono'),
        'mail' => Yii::t('app', 'Mail'),
    );

    $attribute_dispatchnote_options = array(
        'dispatch_note_number' => Yii::t('app', 'Número'),
        'comment' => Yii::t('app', 'Comentario'),
    );

    $attribute_last_location_options = array(
        'name' => Yii::t('app', 'Nombre'),
        'address' => Yii::t('app', 'Dirección'),
        'province' => Yii::t('app', 'Provincia'),
        'locality' => Yii::t('app', 'Localidad'),
        'phone' => Yii::t('app', 'Teléfono'),
        'mail' => Yii::t('app', 'Mail'),
    );

    $attribute_checked_options = array(
        'imei_checked' => Yii::t('app', 'IMEI confirmado'),
        'brand_checked' => Yii::t('app', 'Marca confirmado'),
        'model_checked' => Yii::t('app', 'Modelo confirmado'),
        'carrier_checked' => Yii::t('app', 'Operador confirmado'),
        'paid_price' => Yii::t('app', 'Precio de liquidación'),
        'peoplesoft_order' => Yii::t('app', 'Nº PeopleSoft'),
        'questionary_json_checked' => Yii::t('app', 'Motivos de rechazo'),
        'blacklist' => Yii::t('app', 'Banda negativa'),
        'selling_code' => Yii::t('app', 'Código'),
    );
?>
<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Equipo'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('purchase', '', $attribute_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Punto de Venta'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('point_of_sale', '', $attribute_point_of_sale_options); ?>
</div>

<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Empresa'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('compay', '', $attribute_company_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Usuario'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('user', '', $attribute_user_options); ?>
</div>


<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'cliente'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('seller', '', $attribute_seller_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'N. de envío'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('last_dispatch_note', '', $attribute_dispatchnote_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Última ubicación'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('last_location', '', $attribute_last_location_options); ?>
</div>

<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Equipo confirmado'), array('color' => TbHtml::LABEL_COLOR_SUCCESS)); ?>
<?php echo TbHtml::checkBoxList('purchase_checked', '', $attribute_checked_options); ?>
</div>

<div class="span12" style="margin-left: 0;">
<?php echo TbHtml::submitButton(Yii::t('app', 'Generar archivo Excel'), array('class' => 'btn-success', 'block' => true, 'data-' => ''));?>
</div>
<?php $this->endWidget(); ?>