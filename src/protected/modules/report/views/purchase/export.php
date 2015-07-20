<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Buy'), 'icon' => 'plus-sign', 'url' => array('/retail/purchase/imei')),
);

?>

<?php $form = $this->beginWidget(
    'GxActiveForm', array(
    'id' => 'purchase-form',
    'enableAjaxValidation' => false,
    )
);
?>

<?php
    $attribute_options = array(
        'contract_number' => Yii::t('app', 'Nro. Contrato'),
        'cae' => Yii::t('app', 'C.A.E.'),
        'imei' => Yii::t('app', 'IMEI'),
        'brand' => Yii::t('app', 'Marca'),
        'model' => Yii::t('app', 'Modelo'),
        'purchase_price' => Yii::t('app', 'Precio'),
        'created_at' => Yii::t('app', 'Fecha de creación'),
        'user_ip' => Yii::t('app', 'IP'),
        // 'associate_row' => Yii::t('app', 'Contrato asociado'),
    );

    $attribute_carrier_options = array(
        'name' => Yii::t('app', 'Nombre'),
        'description' => Yii::t('app', 'Descripción'),
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
        'username' => Yii::t('app', 'Nombre de usuario'),
        'mail' => Yii::t('app', 'Mail'),
        // 'last_login' => Yii::t('app', 'Último login'),
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
?>
<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Equipo'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('attributes', '', $attribute_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Operador'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('carrier_attributes', '', $attribute_carrier_options); ?>
</div>

<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Punto de Venta'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('point_of_sale_attributes', '', $attribute_point_of_sale_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Empresa'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('compay_attributes', '', $attribute_company_options); ?>
</div>


<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'Usuario'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('user_attributes', '', $attribute_user_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'cliente'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('seller_attributes', '', $attribute_seller_options); ?>
</div>

<div class="span3">
<?php echo TbHtml::labelTb(Yii::t('app', 'N. de envío'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('dispatchnote_attributes', '', $attribute_dispatchnote_options); ?>

<?php echo TbHtml::labelTb(Yii::t('app', 'Última ubicación'), array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
<?php echo TbHtml::checkBoxList('last_location_attributes', '', $attribute_last_location_options); ?>
</div>

<div class="span12" style="margin-left: 0;">
<?php echo TbHtml::submitButton(Yii::t('app', 'Generar archivo Excel'), array('class' => 'btn-success', 'block' => true, 'data-' => ''));?>
</div>
<?php $this->endWidget(); ?>