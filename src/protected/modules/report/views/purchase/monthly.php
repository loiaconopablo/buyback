<div class="span12">
	
    <?php 
    $form = $this->beginWidget(
        'GxActiveForm', array(
        'id' => 'monthly-form',
        'enableAjaxValidation' => false,
        )
    );
    ?>

	<div>
		<div class="alert alert-block alert-info">
            <?php echo Yii::t('app', $form->labelEx($model, 'Mes')); ?>
            <?php echo $form->dropDownList($model, 'month', CHtml::listData(DateHelper::getMonths(), 'month_number', 'month_name')); ?>

            <?php echo Yii::t('app', $form->labelEx($model, 'Año')); ?>
            <?php echo $form->dropDownList($model, 'year', CHtml::listData($model->getYearsList(), 'year', 'year')); ?>

            <?php echo TbHtml::submitButton(Yii::t('app', 'Ver reporte'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'block' => true)); ?>
		</div>
	</div>

    <!-- MES - DIAS HABILES - DIAS TRANSCURRIDOS -->
    <div class="span span6 nospace">
        <table class="table table-bordered table-striped">
            <thead>
                <th><?php echo Yii::t('app', 'Mes'); ?></th>
                <th><?php echo Yii::t('app', 'Días hábiles'); ?></th>
                <th><?php echo Yii::t('app', 'Días hábiles transcurridos'); ?></th>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo Yii::t('app', DateHelper::getMonthName($model->month)); ?></td>
                    <td style="text-align: center"><?php echo $view_data['dias_habiles_del_mes'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['dias_habiles_transcurridos'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- TOTAL COMPRAS - FORECAST  -->
    <div class="span span6">
        <table class="table table-bordered table-striped">
            <thead>
                <th><?php echo Yii::t('app', 'Total compras'); ?></th>
                <th><?php echo Yii::t('app', 'Promedio diario'); ?></th>
                <th><?php echo Yii::t('app', 'Proyección cierre'); ?></th>
                <th><?php echo Yii::t('app', 'Forecast'); ?></th>
                <th><?php echo Yii::t('app', 'Cierre / Forecast'); ?></th>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center"><?php echo TbHtml::labelTb($view_data['total_compras'], array('color' => TbHtml::LABEL_COLOR_INFO)); ?></td>
                    <td style="text-align: center"><?php echo $view_data['promedio_diario'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['proyeccion_cierre'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['forecast'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['cierre_forecast'] ?> %</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- CANTIDAD POR MARCA -->
    <div class="span span6 nospace">
        <table class="table table-bordered table-striped">
            <thead>
                <th><?php echo Yii::t('app', 'Marca'); ?></th>
                <th><?php echo Yii::t('app', 'Cantidad'); ?></th>
                <th><?php echo Yii::t('app', 'Participación'); ?></th>
            </thead>
            <tbody>
                <?php foreach($view_data['cantidad_por_marca'] as $registro): ?>
                <tr>
                    <td style="text-align: center"><?php echo $registro->brand; ?></td>
                    <td style="text-align: center"><?php echo $registro->quantity; ?></td>
                    <td style="text-align: center"><?php echo round(($registro->quantity * 100) / $view_data['total_compras'], 2); ?> %</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- PUNTOS DE VENTA -->
    <div class="span span6">
        <table class="table table-bordered table-striped">
            <thead>
                <th><?php echo Yii::t('app', 'Puntos de Venta habilitados'); ?></th>
                <th><?php echo Yii::t('app', 'Operativos'); ?></th>
                <th><?php echo Yii::t('app', 'Efectivos'); ?></th>
                <th><?php echo Yii::t('app', 'Promedio de compras'); ?></th>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center"><?php echo $view_data['cantidad_pdv_habilitados'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['cantidad_pdv_operativos'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['cantidad_pdv_efectivos'] ?></td>
                    <td style="text-align: center"><?php echo $view_data['promedio_por_pdv'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PRECIO PROMEDIO POR MARCA -->
    <div class="span span6">
        <table class="table table-bordered table-striped">
            <thead>
                <th><?php echo Yii::t('app', 'Marca'); ?></th>
                <th><?php echo Yii::t('app', 'Precio promedio'); ?></th>
            </thead>
            <tbody>
                <?php foreach($view_data['precio_promedio_por_marca'] as $registro): ?>
                <tr>
                    <td style="text-align: center"><?php echo $registro->brand; ?></td>
                    <td style="text-align: center">$ <?php echo round($registro->price_average, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="span span6 nospace">
        <?php $this->renderPartial('charts/brands_pie', array('cantidad_por_marca' => $view_data['cantidad_por_marca'])); ?>
    </div>

    <div class="span span6">
        <?php $this->renderPartial('charts/brands_price_average_bars', array('precio_promedio_por_marca' => $view_data['precio_promedio_por_marca'])); ?>
    </div>

    <div class="span span12 nospace">
        <?php Yii::app()->controller->widget('AnualForecast', array('year' => $model->year)); ?>
    </div>

    

    <?php $this->endWidget(); ?>

</div>